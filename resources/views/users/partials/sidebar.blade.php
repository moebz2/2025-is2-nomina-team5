<div
    class="sticky border-r border-gray-950/5 top-14 z-10 flex h-full max-h-[calc(100dvh---spacing(14))] flex-col bg-white">
    <div class="flex-1 overflow-y-auto p-6" data-autoscroll="true">
        <ul class="flex flex-col gap-8" role="list">
            <li>
                <ul class="flex flex-col gap-2" role="list">
                    <li>
                        <a @if (request()->is('admin/users')) aria-current="true" @endif
                            class="inline-flex items-center gap-3 text-base/8 text-gray-600 hover:text-gray-950 sm:text-sm/7 **:text-gray-400 **:data-highlight:fill-white **:[svg]:size-5 **:[svg]:sm:size-4 aria-[current]:font-semibold aria-[current]:text-gray-950 aria-[current]:**:text-gray-950 aria-[current]:**:data-highlight:fill-gray-300 hover:**:text-gray-950 hover:**:data-highlight:fill-gray-300"
                            href="{{ route('users.index') }}">
                            {{-- Agregar icono con span o i --}}
                            <i class="material-symbols-outlined">list</i>
                            Lista de usuarios
                        </a>
                    </li>
                    <li>
                        <a @if (request()->is('admin/users/create')) aria-current="true" @endif
                            class="inline-flex items-center gap-3 text-base/8 text-gray-600 hover:text-gray-950 sm:text-sm/7 **:text-gray-400 **:data-highlight:fill-white **:[svg]:size-5 **:[svg]:sm:size-4 aria-[current]:font-semibold aria-[current]:text-gray-950 aria-[current]:**:text-gray-950 aria-[current]:**:data-highlight:fill-gray-300 hover:**:text-gray-950 hover:**:data-highlight:fill-gray-300"
                            href="{{ route('users.create') }}">
                            <i class="material-symbols-outlined">add</i>
                            Crear usuario
                        </a>
                    </li>

                    @if (isset($user))
                        <li>
                            <a aria-current="true"
                                class="inline-flex items-center gap-3 text-base/8 text-gray-600 hover:text-gray-950 sm:text-sm/7 **:text-gray-400 **:data-highlight:fill-white **:[svg]:size-5 **:[svg]:sm:size-4 aria-[current]:font-semibold aria-[current]:text-gray-950 aria-[current]:**:text-gray-950 aria-[current]:**:data-highlight:fill-gray-300 hover:**:text-gray-950 hover:**:data-highlight:fill-gray-300"
                                href="">
                                <i class="material-symbols-outlined">badge</i>
                                {{ $user->nombre }}
                            </a>
                        </li>
                    @endif


                </ul>
            </li>
            {{--  <li class="flex flex-col gap-3">
                <h3 class="font-mono text-sm/6 font-medium tracking-widest text-gray-500 uppercase sm:text-xs/6">
                    Page Sections</h3>
                <ul class="flex flex-col gap-2 border-l border-[color-mix(in_oklab,_var(--color-gray-950),white_90%)]"
                    role="list">
                    <li class="-ml-px flex flex-col items-start gap-2"><a
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button" href="https://tailwindcss.com/plus/ui-blocks/marketing/sections/heroes">Hero
                            Sections</a></li>
                    <li class="-ml-px flex flex-col items-start gap-2"><a
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button"
                            href="https://tailwindcss.com/plus/ui-blocks/marketing/sections/feature-sections">Feature
                            Sections</a></li>
                    <li class="-ml-px flex flex-col items-start gap-2"><a
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button"
                            href="https://tailwindcss.com/plus/ui-blocks/marketing/sections/cta-sections">CTA
                            Sections</a></li>
                    <li class="-ml-px flex flex-col items-start gap-2"><a
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button"
                            href="https://tailwindcss.com/plus/ui-blocks/marketing/sections/bento-grids">Bento
                            Grids</a></li>
                    <li class="-ml-px flex flex-col items-start gap-2"><a
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button"
                            href="https://tailwindcss.com/plus/ui-blocks/marketing/sections/pricing">Pricing
                            Sections</a></li>
                    <li class="-ml-px flex flex-col items-start gap-2"><a
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button"
                            href="https://tailwindcss.com/plus/ui-blocks/marketing/sections/header">Header
                            Sections</a></li>
                    <li class="-ml-px flex flex-col items-start gap-2"><a
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button"
                            href="https://tailwindcss.com/plus/ui-blocks/marketing/sections/newsletter-sections">Newsletter
                            Sections</a></li>
                    <li class="-ml-px flex flex-col items-start gap-2"><a
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button"
                            href="https://tailwindcss.com/plus/ui-blocks/marketing/sections/stats-sections">Stats</a>
                    </li>
                    <li class="-ml-px flex flex-col items-start gap-2"><a
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button"
                            href="https://tailwindcss.com/plus/ui-blocks/marketing/sections/testimonials">Testimonials</a>
                    </li>
                    <li class="-ml-px flex flex-col items-start gap-2"><a
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button"
                            href="https://tailwindcss.com/plus/ui-blocks/marketing/sections/blog-sections">Blog
                            Sections</a></li>
                    <li class="-ml-px flex flex-col items-start gap-2"><a aria-current="page"
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button"
                            href="https://tailwindcss.com/plus/ui-blocks/marketing/sections/contact-sections">Contact
                            Sections</a></li>
                    <li class="-ml-px flex flex-col items-start gap-2"><a
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button"
                            href="https://tailwindcss.com/plus/ui-blocks/marketing/sections/team-sections">Team
                            Sections</a></li>
                    <li class="-ml-px flex flex-col items-start gap-2"><a
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button"
                            href="https://tailwindcss.com/plus/ui-blocks/marketing/sections/content-sections">Content
                            Sections</a></li>
                    <li class="-ml-px flex flex-col items-start gap-2"><a
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button"
                            href="https://tailwindcss.com/plus/ui-blocks/marketing/sections/logo-clouds">Logo
                            Clouds</a></li>
                    <li class="-ml-px flex flex-col items-start gap-2"><a
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button"
                            href="https://tailwindcss.com/plus/ui-blocks/marketing/sections/faq-sections">FAQs</a>
                    </li>
                    <li class="-ml-px flex flex-col items-start gap-2"><a
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button"
                            href="https://tailwindcss.com/plus/ui-blocks/marketing/sections/footers">Footers</a>
                    </li>
                </ul>
            </li>
            <li class="flex flex-col gap-3">
                <h3 class="font-mono text-sm/6 font-medium tracking-widest text-gray-500 uppercase sm:text-xs/6">
                    Elements</h3>
                <ul class="flex flex-col gap-2 border-l border-[color-mix(in_oklab,_var(--color-gray-950),white_90%)]"
                    role="list">
                    <li class="-ml-px flex flex-col items-start gap-2"><a
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button"
                            href="https://tailwindcss.com/plus/ui-blocks/marketing/elements/headers">Headers</a>
                    </li>
                    <li class="-ml-px flex flex-col items-start gap-2"><a
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button"
                            href="https://tailwindcss.com/plus/ui-blocks/marketing/elements/flyout-menus">Flyout
                            Menus</a></li>
                    <li class="-ml-px flex flex-col items-start gap-2"><a
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button"
                            href="https://tailwindcss.com/plus/ui-blocks/marketing/elements/banners">Banners</a>
                    </li>
                </ul>
            </li>
            <li class="flex flex-col gap-3">
                <h3 class="font-mono text-sm/6 font-medium tracking-widest text-gray-500 uppercase sm:text-xs/6">
                    Feedback</h3>
                <ul class="flex flex-col gap-2 border-l border-[color-mix(in_oklab,_var(--color-gray-950),white_90%)]"
                    role="list">
                    <li class="-ml-px flex flex-col items-start gap-2"><a
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button"
                            href="https://tailwindcss.com/plus/ui-blocks/marketing/feedback/404-pages">404
                            Pages</a></li>
                </ul>
            </li>
            <li class="flex flex-col gap-3">
                <h3 class="font-mono text-sm/6 font-medium tracking-widest text-gray-500 uppercase sm:text-xs/6">
                    Page Examples</h3>
                <ul class="flex flex-col gap-2 border-l border-[color-mix(in_oklab,_var(--color-gray-950),white_90%)]"
                    role="list">
                    <li class="-ml-px flex flex-col items-start gap-2"><a
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button"
                            href="https://tailwindcss.com/plus/ui-blocks/marketing/page-examples/landing-pages">Landing
                            Pages</a></li>
                    <li class="-ml-px flex flex-col items-start gap-2"><a
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button"
                            href="https://tailwindcss.com/plus/ui-blocks/marketing/page-examples/pricing-pages">Pricing
                            Pages</a></li>
                    <li class="-ml-px flex flex-col items-start gap-2"><a
                            class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                            type="button"
                            href="https://tailwindcss.com/plus/ui-blocks/marketing/page-examples/about-pages">About
                            Pages</a></li>
                </ul>
            </li> --}}
        </ul>
    </div>
    <div class="border-t border-gray-950/5 px-3 py-2">
        <h4 class="font-medium text-sm">Recomendaciones</h4>



        @if (request()->is('admin/users'))
            <p class="text-sm text-gray-500">
                Las acciones en la lista de empleados permiten editar, dar de baja o ver los datos del empleado
            </p>
            <p class="text-sm text-gray-500">

            </p>
        @elseif (request()->is('admin/users/create'))
            <p class="text-sm text-gray-500">
                Al crear un usuario es importante asignarle el rol correcto para proteger los recursos a los que puede
                acceder
            </p>
            <p class="text-sm text-gray-500">
                No olvides de rellenar todos los campos requeridos
            </p>
        @else
            <p class="text-sm text-gray-500">
                Puedes agregar movimientos, conceptos, préstamos e hijos directamente en el perfil del usuario. También
                modificar el salario o el estado actual del empleado.
            </p>
            <p class="text-sm text-gray-500">

            </p>
        @endif
    </div>
</div>
