<?php

namespace App\Livewire\Dashboard;

use App\Models\Category;
use App\Models\AppService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithFileUploads;

    public $name, $url, $category_id, $image, $editingAppId, $currentImage;

    protected $rules = [
        'name' => 'required|min:3|max:13',
        'url' => 'required|url',
        'category_id' => 'nullable|exists:categories,id',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
    ];

    public function updatedImage()
    {
        $this->validateOnly('image');
    }

    public function editApp($id)
    {
        $this->resetFields();
        $app = AppService::where('user_id', Auth::id())->findOrFail($id);

        $this->editingAppId = $app->id;
        $this->currentImage = $app->image_path;
        $this->name = $app->name;
        $this->url = $app->url;
        $this->category_id = $app->category_id;

        $this->dispatch('open-modal');
    }

    public function saveApp()
    {
        $this->validate();

        try {
            $userPath = 'users/' . Auth::id() . '/apps';

            // --- LÓGICA DE CATEGORÍA AUTOMÁTICA ---
            if (empty($this->category_id)) {
                // Buscamos si el usuario ya tiene la categoría "Sin categoría"
                $defaultCategory = Category::firstOrCreate(
                    ['user_id' => Auth::id(), 'name' => 'Sin categoría'],
                    ['icon' => null] // Puedes poner un icono por defecto aquí si quieres
                );
                $finalCategoryId = $defaultCategory->id;
            } else {
                $finalCategoryId = $this->category_id;
            }

            if ($this->editingAppId) {
                // --- MODO EDICIÓN ---
                $app = AppService::where('user_id', Auth::id())->findOrFail($this->editingAppId);

                $path = $this->image ? $this->image->store($userPath, 'public') : null;

                $app->update([
                    'name' => $this->name,
                    'url' => $this->url,
                    'category_id' => $finalCategoryId,
                    'image_path' => $path
                ]);
            } else {
                // --- MODO CREACIÓN ---
                $path = $this->image ? $this->image->store($userPath, 'public') : null;

                AppService::create([
                    'user_id' => Auth::id(),
                    'name' => $this->name,
                    'url' => $this->url,
                    'image_path' => $path,
                    'category_id' => $finalCategoryId, // Ahora siempre tendrá un ID
                    'is_favorite' => false,
                ]);
            }

            $this->resetFields();
            $this->dispatch('close-modal-success');
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function deleteApp()
    {
        if (!$this->editingAppId) return;

        $app = AppService::where('user_id', Auth::id())->findOrFail($this->editingAppId);

        if ($app->image_path) {
            Storage::disk('public')->delete($app->image_path);
        }

        $app->delete();

        $this->resetFields();
        $this->dispatch('close-modal-success');
    }

    public function resetFields()
    {
        $this->reset(['name', 'url', 'image', 'category_id', 'editingAppId', 'currentImage']);
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.dashboard.index', [
            'categories' => Category::where('user_id', Auth::id())->with('apps')->get(),
            'favorites' => AppService::where('user_id', Auth::id())->where('is_favorite', true)->get()
        ]);
    }

    public function toggleFavorite($appId)
    {
        $app = AppService::where('user_id', Auth::id())->findOrFail($appId);

        $app->update([
            'is_favorite' => !$app->is_favorite
        ]);
    }
}
