<?php

namespace App\Livewire\Category;

use App\Models\Category;
use App\Models\AppService; 
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $name, $icon;
    public $editingCategoryId = null;
    public $currentIcon = null;

    protected function rules()
    {
        return [
            'name' => 'required|min:3|max:15|unique:categories,name,' . $this->editingCategoryId,
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
        ];
    }

    public function editCategory($id)
    {
        $this->resetFields();

        $category = Category::where('user_id', Auth::id())->findOrFail($id);

        $this->editingCategoryId = $category->id;
        $this->name = $category->name;
        $this->currentIcon = $category->icon;

        $this->dispatch('open-modal');
    }

    public function resetFields()
    {
        $this->reset(['name', 'icon', 'editingCategoryId', 'currentIcon']);
        $this->resetErrorBag();
        $this->resetPage();
    }

    public function save()
    {
        $this->validate();

        try {
            
            $userPath = 'users/' . Auth::id() . '/category-icons';

            if ($this->editingCategoryId) {
                $category = Category::where('user_id', Auth::id())->findOrFail($this->editingCategoryId);
                $iconPath = $category->icon;

                if ($this->icon instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                    if ($category->icon) {
                        Storage::disk('public')->delete($category->icon);
                    }
                    
                    $iconPath = $this->icon->store($userPath, 'public');
                }

                $category->update([
                    'name' => $this->name,
                    'icon' => $iconPath,
                ]);
            } else {
                $iconPath = null;

                if ($this->icon) {

                    $iconPath = $this->icon->store($userPath, 'public');
                }

                Category::create([
                    'name' => $this->name,
                    'icon' => $iconPath,
                    'user_id' => Auth::id(),
                ]);
            }

            $this->resetFields();
            $this->dispatch('category-created');
        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al guardar: ' . $e->getMessage());
        }
    }

    public function deleteCategory($id)
    {
        $category = Category::where('user_id', Auth::id())->findOrFail($id);

        try {
            if ($category->icon) {
                Storage::disk('public')->delete($category->icon);
            }

            $appsEncontradas = AppService::where('category_id', $category->id)->get();

            foreach ($appsEncontradas as $unaApp) {
                if ($unaApp->image_path) {
                    Storage::disk('public')->delete($unaApp->image_path);
                }

                $unaApp->delete();
            }

            $category->delete();

            if ($this->editingCategoryId == $id) {
                $this->resetFields();
            }

            $this->dispatch('category-created');
            session()->flash('success', 'Categoría y sus apps eliminadas correctamente.');
        } catch (\Exception $e) {

            session()->flash('error', 'Error técnico: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.category.index', [
            'categories' => Category::where('user_id', Auth::id())->latest()->simplePaginate(5)
        ]);
    }
}
