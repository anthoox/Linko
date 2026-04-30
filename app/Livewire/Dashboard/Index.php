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

    public $appToDeleteId = null;
    public $appToDeleteName = null;

    protected $rules = [
        'name' => 'required|min:3|max:15',
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

            if (empty($this->category_id)) {
                $defaultCategory = Category::firstOrCreate(
                    ['user_id' => Auth::id(), 'name' => 'General'],
                    ['icon' => null]
                );

                $finalCategoryId = $defaultCategory->id;
            } else {
                $finalCategoryId = $this->category_id;
            }

            if ($this->editingAppId) {
                $app = AppService::where('user_id', Auth::id())->findOrFail($this->editingAppId);

                if ($this->image) {
                    if ($app->image_path) {
                        Storage::disk('public')->delete($app->image_path);
                    }

                    $path = $this->image->store($userPath, 'public');
                } else {
                    $path = $app->image_path;
                }

                $app->update([
                    'name' => $this->name,
                    'url' => $this->url,
                    'category_id' => $finalCategoryId,
                    'image_path' => $path,
                ]);
            } else {
                $path = $this->image ? $this->image->store($userPath, 'public') : null;

                AppService::create([
                    'user_id' => Auth::id(),
                    'name' => $this->name,
                    'url' => $this->url,
                    'image_path' => $path,
                    'category_id' => $finalCategoryId,
                    'is_favorite' => false,
                ]);
            }

            $wasEditing = $this->editingAppId !== null;

            $this->resetFields();

            $this->dispatch('close-modal-success');

            $this->dispatch(
                'show-toast',
                type: 'success',
                message: $wasEditing ? 'Servicio actualizado correctamente.' : 'Servicio creado correctamente.'
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'show-toast',
                type: 'error',
                message: 'Error: ' . $e->getMessage()
            );
        }
    }

    public function confirmDeleteApp()
    {
        if (!$this->editingAppId) {
            return;
        }

        $app = AppService::where('user_id', Auth::id())->findOrFail($this->editingAppId);

        $this->appToDeleteId = $app->id;
        $this->appToDeleteName = $app->name;

        $this->dispatch('open-delete-app-modal');
    }

    public function deleteApp()
    {
        if (!$this->appToDeleteId) {
            return;
        }

        try {
            $app = AppService::where('user_id', Auth::id())->findOrFail($this->appToDeleteId);

            if ($app->image_path) {
                Storage::disk('public')->delete($app->image_path);
            }

            $app->delete();

            $this->resetFields();
            $this->resetDeleteAppFields();

            $this->dispatch('close-delete-app-modal');
            $this->dispatch('close-modal-success');

            $this->dispatch(
                'show-toast',
                type: 'success',
                message: 'Servicio eliminado correctamente.'
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'show-toast',
                type: 'error',
                message: 'Error al eliminar el servicio: ' . $e->getMessage()
            );
        }
    }

    public function resetDeleteAppFields()
    {
        $this->reset(['appToDeleteId', 'appToDeleteName']);
    }

    public function resetFields()
    {
        $this->reset(['name', 'url', 'image', 'category_id', 'editingAppId', 'currentImage']);
        $this->resetErrorBag();
    }

    public function render()
    {
        $categories = Category::where('user_id', Auth::id())
            ->with('apps')
            ->get()
            ->sortBy(function ($category) {
                if ($category->name === 'General') {
                    return 999999;
                }

                return -$category->id;
            });

        return view('livewire.dashboard.index', [
            'categories' => $categories,
            'favorites' => AppService::where('user_id', Auth::id())
                ->where('is_favorite', true)
                ->get(),
        ]);
    }

    public function toggleFavorite($appId)
    {
        $app = AppService::where('user_id', Auth::id())->findOrFail($appId);

        $app->update([
            'is_favorite' => !$app->is_favorite,
        ]);
    }
}