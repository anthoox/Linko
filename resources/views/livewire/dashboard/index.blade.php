<div class="w-full" x-data="{ modalIsOpen: false }" x-on:close-modal-success.window="modalIsOpen = false">

    <div class="flex flex-col items-center w-full">

        <!-- LISTA DE CATEGORIAS -->
        <div class="mb-8 w-full flex flex-col  max-w-6xl mt-4">
            @if ($categories->count() > 0)
            <div class="flex gap-2 items-end mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-7" viewBox="0 0 32 32">
                    <path fill="#777777" d="M27 22.141V18a2 2 0 0 0-2-2h-8v-4h2a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2v4H7a2 2 0 0 0-2 2v4.142a4 4 0 1 0 2 0V18h8v4.142a4 4 0 1 0 2 0V18h8v4.141a4 4 0 1 0 2 0M13 4h6l.001 6H13ZM8 26a2 2 0 1 1-2-2a2 2 0 0 1 2 2m10 0a2 2 0 1 1-2-2a2.003 2.003 0 0 1 2 2m8 2a2 2 0 1 1 2-2a2 2 0 0 1-2 2" />
                </svg>
                <h3 class="dark:text-gray-300 text-gray-600  text-base font-medium">Categorías</h3>
            </div>


            @endif

            <ul class="flex justify-start gap-2 flex-wrap max-w-6xl">
                @forelse($categories as $category)

                <li wire:key="nav-cat-{{ $category->id }}" class="whitespace-nowrap rounded-radius px-4 py-2 text-sm dark:text-gray-300 text-gray-600  font-medium tracking-wide text-center transition-all duration-300 border-2 hover:text-violet-700 bg-gray-100 border-gray-100 hover:border-gray-300 dark:bg-dub-surface dark:border-dub-surface  dark:hover:text-linko-purple   dark:hover:border-dub-border">
                    <a href="#{{ Str::slug($category->name) }}">{{ $category->name }}</a>
                </li>
                @empty
                <li class="flex justify-start whitespace-nowrap rounded-radius px-4 py-2 text-sm font-medium tracking-wide text-center  pointer-events-none border-2 bg-white dark:bg-dub-surface dark:border-dub ">
                    <span class="text-gray-600 " href="#">No hay categorías aún</span>
                </li>
                @endforelse
            </ul>
        </div>

        <!-- APPS -->
        <div class="flex flex-col gap-7 mb-8 w-full max-w-6xl text-center">

            <!-- FAVORITOS -->
            <div class="flex justify-start h-full flex-1 flex-col gap-4 max-w-6xl">
                <!-- TITULO FAVORITOS -->
                @if ($favorites->count() > 0)
                <div class="flex flex-col gap-2">
                    <div class="flex items-end gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-7" viewBox="0 0 24 24">
                            <path fill="#eab308" d="M22 10.1c.1-.5-.3-1.1-.8-1.1l-5.7-.8L12.9 3c-.1-.2-.2-.3-.4-.4c-.5-.3-1.1-.1-1.4.4L8.6 8.2L2.9 9q-.45 0-.6.3c-.4.4-.4 1 0 1.4l4.1 4l-1 5.7c0 .2 0 .4.1.6c.3.5.9.7 1.4.4l5.1-2.7l5.1 2.7c.1.1.3.1.5.1h.2c.5-.1.9-.6.8-1.2l-1-5.7l4.1-4c.2-.1.3-.3.3-.5" />
                        </svg>
                        <h3 class="dark:text-gray-300 text-gray-600  text-base font-medium">Favoritos</h3>
                    </div>
                </div>

                <!-- APPS FAVORITAS -->
                <div class=" flex gap-2 flex-wrap">

                    @forelse($favorites as $fav)

                    <a href="{{ $fav->url }}" target="_blank" wire:key="fav-item-{{ $fav->id }}" class="featured__item featured__item--first dark:hover:text-linko-purple hover:text-violet-700 dark:text-gray-300 text-gray-600  font-medium
                    bg-white border-2 border-gray-300 hover:border-violet-700 
                    dark:bg-dub-surface dark:border-dub-border dark:hover:border-linko-purple 
                    transition-colors duration-300 cursor-pointer">
                        <div class="featured__icon bg-gray-100 dark:bg-dub-border  dark:border-dub-border ">
                            <img class="featured__icon-img featured__icon-img--first" src="{{ $fav->image_path ? asset('storage/' . $fav->image_path) : asset('assets/img/app.svg') }}" alt="{{ $fav->name }}">
                        </div>
                        <div class="featured__description">
                            <h3 class="text-sm transition-colors duration-300">{{ $fav->name }}</h3>

                        </div>
                        <i class="featured__arrow las la-angle-right  dark:hover:text-linko-purple"></i>
                    </a>

                    @empty
                    <div class="flex justify-start gap-2 flex-wrap">
                        <div class="flex justify-start whitespace-nowrap rounded-radius px-4 py-2 text-sm font-medium tracking-wide text-center  pointer-events-none">
                            <span class="text-gray-600 ">No hay favoritos aún</span>
                        </div>
                    </div>
                    @endforelse

                </div>
                @else
                <div class="flex justify-start gap-2 flex-wrap duration-300 transition-transform ">
                    <div class="flex justify-start whitespace-nowrap rounded-radius px-4 py-2 text-sm font-medium tracking-wide text-center  pointer-events-none border-2 bg-white dark:bg-dub-surface dark:border-dub  border-gray-200 ">
                        <span class="text-gray-600 ">No hay favoritos aún</span>
                    </div>
                </div>
                @endif

            </div>

            <!-- RESTO DE APPS -->
            @forelse($categories as $category)
            <div wire:key="cat-section-{{ $category->id }}" id="{{ Str::slug($category->name) }}" class="flex justify-start h-full w-full flex-1 flex-col gap-4 rounded-xl max-w-6xl">
                <div class="flex items-end gap-2">
                    @if($category->icon)


                    <img src="{{ $category->icon ? asset('storage/' . $category->icon) : asset('assets/img/app.svg') }}" class="size-7 object-cover rounded-md">
                    @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-7" viewBox="0 0 24 24">
                        <path fill="#666666" d="M8.75 13A2.25 2.25 0 0 1 11 15.25v3.5A2.25 2.25 0 0 1 8.75 21h-3.5A2.25 2.25 0 0 1 3 18.75v-3.5A2.25 2.25 0 0 1 5.25 13zm10-10A2.25 2.25 0 0 1 21 5.25v3.5A2.25 2.25 0 0 1 18.75 11h-3.5A2.25 2.25 0 0 1 13 8.75v-3.5A2.25 2.25 0 0 1 15.25 3z" class="duoicon-secondary-layer" opacity=".3" />
                        <path fill="#777777" d="M8.75 3A2.25 2.25 0 0 1 11 5.25v3.5A2.25 2.25 0 0 1 8.75 11h-3.5A2.25 2.25 0 0 1 3 8.75v-3.5A2.25 2.25 0 0 1 5.25 3z" class="duoicon-primary-layer" />
                        <path fill="#666666" d="M18.75 13A2.25 2.25 0 0 1 21 15.25v3.5A2.25 2.25 0 0 1 18.75 21h-3.5A2.25 2.25 0 0 1 13 18.75v-3.5A2.25 2.25 0 0 1 15.25 13z" class="duoicon-secondary-layer" opacity=".3" />
                    </svg>

                    @endif
                    <h3 class="text-md dark:text-gray-300 font-medium text-gray-600" id="categoria-{{ $category->name }}">{{ $category->name }}</h3>
                </div>
                <div class="flex gap-2 flex-wrap">

                    @forelse($category->apps as $app)
                    <div wire:key="app-{{ $app->id }}" class="featured__item bg-white border-2 border-gray-300 hover:border-linko-purple 
            dark:bg-dub-surface dark:border-dub-border dark:hover:border-linko-purple font-medium text-gray-600  
            transition-colors duration-300 dark:hover:text-linko-purple hover:text-violet-700 cursor-pointer  dark:text-gray-300 ">
                        <a href="{{ $app->url }}" target="_blank" class="absolute inset-0 z-0"></a>
                        <div class=" flex items-center gap-1 ">
                            <div class="featured__icon dark:bg-dub-border ">
                                <img class="featured__icon-img bg-gray-100  dark:bg-dub-border rounded-md dark:border-dub-border" src="{{ $app->image_path ? asset('storage/' . $app->image_path) : asset('assets/img/app.svg') }}" alt="{{ $app->name }}">
                            </div>

                            <div class="featured__description ">
                                <h3 class="text-sm  transition-colors">{{ $app->name }}</h3>

                            </div>
                            <div>
                                <button
                                    wire:click.stop="toggleFavorite({{ $app->id }})"
                                    wire:loading.attr="disabled"
                                    class="absolute top-0 right-1 z-10 py-1 transition-transform active:scale-95"
                                    title="Marcar como favorito">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="currentColor"
                                        class="size-4 transition-colors duration-150 {{ $app->is_favorite ? 'text-linko-purple ' : 'text-gray-300 dark:text-gray-600' }}">
                                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <button
                                    wire:click.stop="editApp({{ $app->id }})" x-on:click.stop="modalIsOpen = true"
                                    wire:loading.attr="disabled"
                                    class="absolute bottom-0 right-1 z-10 py-1 transition-transform active:scale-95"
                                    title="Editar App">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="size-4 transition-colors duration-150  text-gray-300 dark:text-gray-600">
                                        <path fill="#666666" d="M4.42 20.579a1 1 0 0 1-.737-.326a.988.988 0 0 1-.263-.764l.245-2.694L14.983 5.481l3.537 3.536L7.205 20.33l-2.694.245a.95.95 0 0 1-.091.004ZM19.226 8.31L15.69 4.774l2.121-2.121a1 1 0 0 1 1.415 0l2.121 2.121a1 1 0 0 1 0 1.415l-2.12 2.12l-.001.001Z" />
                                    </svg>
                                </button>
                            </div>

                        </div>

                    </div>
                    @empty
                    <div class="flex justify-start whitespace-nowrap rounded-radius px-4 py-2 text-sm font-medium tracking-wide text-center  pointer-events-none border-2 bg-white dark:bg-dub-surface dark:border-dub ">
                        <span class="text-gray-600 ">Categoría vacía</span>
                    </div>
                    @endforelse
                </div>
            </div>
            @empty
            <div class="flex justify-start gap-2 flex-wrap">
                <div class="flex justify-start whitespace-nowrap rounded-radius px-4 py-2 text-sm font-medium tracking-wide text-center  pointer-events-none border-2 bg-white dark:bg-dub-surface dark:border-dub ">
                    <span class="text-gray-600 ">No hay aplicaciones aún</span>
                </div>
            </div>
            @endforelse

        </div>

        <!-- MODAL AÑADIR APP -->
        <div class="fixed inset-x-0 bottom-0 z-50 pointer-events-none">
            <div class="mx-auto max-w-6xl w-full relative h-24">

                <div class="absolute bottom-10 right-6 lg:right-0 pointer-events-auto">
                    <div x-data="{ modalIsOpen: false }" x-on:close-modal-success.window="modalIsOpen = false" x-on:open-modal.window="modalIsOpen = true">
                        <button wire:click="resetFields" x-on:click="modalIsOpen = true" type="button" class="whitespace-nowrap border rounded-full border-primary dark:border-primary-dark bg-primary px-4 py-4 text-center text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 dark:bg-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">
                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-6 fill-on-primary dark:fill-on-primary-dark" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-cloak x-show="modalIsOpen" x-transition.opacity.duration.200ms x-trap.inert.noscroll="modalIsOpen" x-on:keydown.esc.window="modalIsOpen = false" x-on:click.self="modalIsOpen = false" class="fixed inset-0 z-30 flex w-full items-center justify-center bg-black/20 p-4 pb-8 backdrop-blur-md lg:p-8" role="dialog" aria-modal="true" aria-labelledby="defaultModalTitle">

                            <form wire:submit.prevent="saveApp" x-show="modalIsOpen" x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity" x-transition:enter-start="scale-0" x-transition:enter-end="scale-100" class="flex w-full max-w-lg flex-col gap-4 overflow-hidden rounded-radius border border-outline bg-surface text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark shadow-2xl mx-4 sm:mx-0">

                                <div class="flex items-center justify-between border-b border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20">
                                    <h3 id="defaultModalTitle" class="font-semibold tracking-wide text-on-surface-strong dark:text-on-surface-dark-strong">{{ $editingAppId ? 'Editar Aplicación' : 'Nueva Aplicación' }}</h3>
                                    <button type="button" x-on:click="modalIsOpen = false" aria-label="close modal">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <!-- Dialog Body -->
                                <div class="px-4 py-8">
                                    <div class="flex w-full flex-col gap-1 text-on-surface dark:text-on-surface-dark">
                                        <label for="name" class="w-fit pl-0.5 text-sm">Nombre</label>
                                        <input id="name" wire:model="name" type="text" class="w-full rounded-radius border border-outline bg-surface-alt px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark" placeholder="Nombre de la Aplicación" />
                                        @error('name') <span class="text-xs text-start text-red-500 ml-1">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="flex w-full flex-col gap-1 text-on-surface dark:text-on-surface-dark mt-4">
                                        <label for="url" class="w-fit pl-0.5 text-sm">URL</label>
                                        <input id="url" wire:model="url" type="text" class="w-full rounded-radius border border-outline bg-surface-alt px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark" placeholder="Añade la URL" />
                                        @error('url') <span class="text-xs text-start text-red-500 ml-1">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="relative flex w-full flex-col gap-1 text-on-surface dark:text-on-surface-dark mt-4">
                                        <label for="category_id" class="w-fit pl-0.5 text-sm">Categoría</label>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="absolute pointer-events-none right-4 top-8 size-5">
                                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                        </svg>
                                        <select id="category_id" wire:model="category_id" class="w-full appearance-none rounded-radius border border-outline bg-surface-alt px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark">
                                            <option value="">Sin categoría</option>
                                            @foreach($categories as $cat)
                                            @if($cat->name !== 'Sin categoría')
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="relative flex w-full flex-col gap-1 mt-4">
                                        <label class="w-fit pl-0.5 text-sm text-on-surface dark:text-on-surface-dark" for="image">Imagen</label>

                                        <input id="image" type="file" wire:model.live="image" class="w-full cursor-pointer overflow-clip rounded-radius border border-outline bg-surface-alt/50 text-sm text-on-surface transition-all
            file:mr-6 file:border-none file:bg-linko-purple file:px-4 file:py-2.5 file:text-xs file:tracking-widest file:text-white 
            hover:border-linko-purple/50 focus:outline-none disabled:cursor-not-allowed disabled:opacity-75 
            dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:text-on-surface-dark dark:file:bg-linko-purple dark:focus-visible:outline-linko-purple" accept="image/*" />

                                        <div wire:loading wire:target="image" class="text-xs text-blue-500 mt-1">Procesando imagen...</div>

                                        @if ($image && !$errors->has('image'))
                                        <div class="mt-2 text-xs text-green-600 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Listo: {{ $image->getClientOriginalName() }}
                                        </div>
                                        @endif
                                        @error('image') <span class="text-xs text-start text-red-500 mt-1 font-medium">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="flex flex-col-reverse justify-between gap-2 border-t border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20 sm:flex-row sm:items-center md:justify-end">
                                    @if($editingAppId)
                                    <button
                                        type="button"
                                        wire:click="deleteApp"
                                        wire:confirm="¿Estás seguro de que quieres eliminar esta aplicación?"
                                        class="whitespace-nowrap rounded-radius bg-red-500/10 px-4 py-2 text-center text-sm font-medium text-red-600 transition hover:bg-red-500 hover:text-white">
                                        Eliminar
                                    </button>
                                    @endif
                                    <button x-on:click="modalIsOpen = false" type="button" class="whitespace-nowrap rounded-radius px-4 py-2 text-center text-sm font-medium tracking-wide text-on-surface transition hover:opacity-75 dark:text-on-surface-dark">Cancelar</button>
                                    <button type="submit" wire:loading.attr="disabled" wire:target="saveApp, image" class="whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 dark:bg-primary-dark dark:border-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">
                                        <span wire:loading.remove wire:target="saveApp">{{ $editingAppId ? 'Actualizar' : 'Guardar' }}</span>
                                        <span wire:loading wire:target="saveApp">Guardando...</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>