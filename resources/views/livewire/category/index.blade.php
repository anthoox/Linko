<div class="w-full max-w-5xl mx-auto ">
    <div x-data="{modalIsOpen: false}" x-on:category-created.window="modalIsOpen = false"
        x-on:open-modal.window="modalIsOpen = true"
        x-on:keydown.esc.window="modalIsOpen = false">
        <button x-on:click="modalIsOpen = true" wire:click="resetFields" type="button" class="whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 dark:bg-primary-dark dark:border-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">Nueva Categoría</button>
        <div x-cloak x-show="modalIsOpen" x-transition.opacity.duration.200ms x-trap.inert.noscroll="modalIsOpen" x-on:keydown.esc.window="modalIsOpen = false" x-on:click.self="modalIsOpen = false" class="fixed inset-0 z-30 flex w-full items-center justify-center bg-black/20 p-4 pb-8 backdrop-blur-md lg:p-8" role="dialog" aria-modal="true" aria-labelledby="defaultModalTitle">
            <!-- Modal Dialog -->
            <form wire:submit.prevent="save" x-show="modalIsOpen" x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity" x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100" class="flex max-w-lg min-w-lg flex-col gap-4 overflow-hidden rounded-radius border border-outline bg-surface text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">
                <!-- Dialog Header -->
                <div class="flex items-center justify-between border-b border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20">
                    <h3 id="defaultModalTitle" class="font-semibold tracking-wide text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ $editingCategoryId ? 'Editar Categoría' : 'Nueva Categoría' }}
                    </h3>
                    <button x-on:click="modalIsOpen = false" aria-label="close modal">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <!-- Dialog Body -->
                <div class="px-4 py-8">
                    <div class="flex w-full flex-col gap-1 text-on-surface dark:text-on-surface-dark">
                        <label for="name" class="w-fit pl-0.5 text-sm">Nombre</label>
                        <input id="name" wire:model="name" type="text" class="w-full rounded-radius border border-outline bg-surface-alt px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark" name="name" placeholder="Nombre categoría" />
                        @error('name')
                        <span class="text-xs text-red-500 ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="relative flex w-full flex-col gap-2 mt-4">
                        <label class="w-fit pl-0.5 text-sm font-semibold text-on-surface dark:text-on-surface-dark" for="icon">
                            Icono de la categoría
                        </label>

                        <div class="group relative">
                            <input id="icon" type="file" wire:model="icon"
                                class="w-full cursor-pointer overflow-clip rounded-radius border border-outline bg-surface-alt/50 text-sm text-on-surface transition-all
            file:mr-6 file:border-none file:bg-linko-purple file:px-4 file:py-2.5 file:text-xs file:tracking-widest file:text-white 
            hover:border-linko-purple/50 focus:outline-none disabled:cursor-not-allowed disabled:opacity-75 
            dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:text-on-surface-dark dark:file:bg-linko-purple dark:focus-visible:outline-linko-purple" />

                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none opacity-40">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                            </div>
                        </div>

                        @if ($icon || $currentIcon)
                        <div class="mt-2 flex items-center gap-4 rounded-radius border border-outline/50 bg-surface-alt/30 p-3 dark:border-outline-dark/50 dark:bg-surface-dark-alt/30">
                            <div class="relative size-14 shrink-0 overflow-hidden rounded-md border-2 border-white shadow-sm dark:border-dub-border">
                                <img src="{{ $icon ? $icon->temporaryUrl() : asset('storage/' . $currentIcon) }}" class="h-full w-full object-cover">
                            </div>
                            <div class="flex flex-col">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-linko-purple">
                                    {{ $icon ? 'Nueva imagen' : 'Icono actual' }}
                                </p>
                                <p class="text-xs text-on-surface/60 dark:text-on-surface-dark/60">
                                    {{ $icon ? 'Lista para subir' : 'Almacenado en servidor' }}
                                </p>
                            </div>

                            <div wire:loading wire:target="icon" class="ml-auto">
                                <svg class="h-5 w-5 animate-spin text-linko-purple" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>
                        @endif

                        @error('icon') <span class="ml-1 mt-1 text-xs font-medium text-red-500">{{ $message }}</span> @enderror
                    </div>

                </div>
                <!-- Dialog Footer -->
                <div class="flex flex-col-reverse justify-between gap-2 border-t border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20 sm:flex-row sm:items-center md:justify-end">
                    @if($editingCategoryId)
                    <button
                        type="button"
                        wire:click="deleteCategory({{ $editingCategoryId }})"
                        wire:confirm="¿Estás seguro de que quieres eliminar esta categoría? Las apps asociadas quedarán sin categoría."
                        class="whitespace-nowrap rounded-radius bg-red-500/10 px-4 py-2 text-sm font-medium text-red-600 transition hover:bg-red-500 hover:text-white">
                        Eliminar
                    </button>
                    @endif
                    <button x-on:click="modalIsOpen = false" type="button" class="whitespace-nowrap rounded-radius px-4 py-2 text-center text-sm font-medium tracking-wide text-on-surface transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 dark:text-on-surface-dark dark:focus-visible:outline-primary-dark">Cancelar</button>
                    <button type="submit" class="whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 dark:bg-primary-dark dark:border-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">
                        <span wire:loading.remove>{{ $editingCategoryId ? 'Actualizar' : 'Guardar' }}</span>
                        <span wire:loading>Procesando...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-4 overflow-hidden w-full overflow-x-auto rounded-radius border border-outline dark:border-outline-dark">
        <table class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
            <thead class="border-b border-outline bg-surface-alt text-sm text-on-surface-strong dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark-strong">
                <tr>
                    <th scope="col" class="p-4">ID</th>
                    <th scope="col" class="p-4">Nombre</th>
                    <th scope="col" class="p-4">Icono</th>
                    <th scope="col" class="p-4">Fecha creación</th>
                    <th scope="col" class="p-4">Última modificación</th>
                    <th scope="col" class="p-4">Editar</th>
                    <th scope="col" class="p-4">Eliminar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline dark:divide-outline-dark">
                @forelse($categories as $category)
                <tr>
                    <td class="p-4">
                        <div class="flex w-max items-center gap-2">
                            <div class="flex flex-col">
                                <span class="text-black dark:text-neutral-100">{{ $category->id }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="p-4">{{ $category->name }}</td>
                    <td class="p-4">
                        <div class="flex w-max items-center gap-2">
                            @if($category->icon)
                            <img class="size-10 rounded-full object-cover" src="{{ asset('storage/' . $category->icon) }}" alt="category icon" />
                            @else
                            <div class="size-10 rounded-full bg-gray-200 flex items-center justify-center text-xs">N/A</div>
                            @endif
                        </div>
                    </td>
                    <td class="p-4">{{ $category->created_at->format('d-m-Y') }}</td>
                    <td class="p-4">{{ $category->updated_at->format('d-m-Y') }}</td>
                    <td class="p-4">
                        <button type="button" type="button"
                            wire:click="editCategory({{ $category->id }})"
                            x-on:click="modalIsOpen = true"
                            class="whitespace-nowrap rounded-radius bg-transparent p-0.5 hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 active:opacity-100 active:outline-offset-0">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-6">
                                <path fill="none" stroke="#666666" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14 6l2.293-2.293a1 1 0 0 1 1.414 0l2.586 2.586a1 1 0 0 1 0 1.414L18 10m-4-4l-9.707 9.707a1 1 0 0 0-.293.707V19a1 1 0 0 0 1 1h2.586a1 1 0 0 0 .707-.293L18 10m-4-4l4 4" />
                            </svg>
                        </button>
                    </td>
                    <td class="p-4">
                        <button type="button"
                            wire:click="deleteCategory({{ $category->id }})"
                            wire:confirm="¿Estás seguro de querer eliminar la categoría '{{ $category->name }}'? Esto no se puede deshacer."
                            class="whitespace-nowrap rounded-radius bg-transparent p-0.5 hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 active:opacity-100 active:outline-offset-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24">
                                <g fill="none">
                                    <path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                    <path fill="#666666" d="M14.28 2a2 2 0 0 1 1.897 1.368L16.72 5H20a1 1 0 1 1 0 2l-.003.071l-.867 12.143A3 3 0 0 1 16.138 22H7.862a3 3 0 0 1-2.992-2.786L4.003 7.07L4 7a1 1 0 0 1 0-2h3.28l.543-1.632A2 2 0 0 1 9.721 2zm3.717 5H6.003l.862 12.071a1 1 0 0 0 .997.929h8.276a1 1 0 0 0 .997-.929zM10 10a1 1 0 0 1 .993.883L11 11v5a1 1 0 0 1-1.993.117L9 16v-5a1 1 0 0 1 1-1m4 0a1 1 0 0 1 1 1v5a1 1 0 1 1-2 0v-5a1 1 0 0 1 1-1m.28-6H9.72l-.333 1h5.226z" />
                                </g>
                            </svg>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="p-4 text-center" colspan="7">
                        Categorias no encontradas
                    </td>
                    @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $categories->links() }}
        </div>
    </div>

</div>