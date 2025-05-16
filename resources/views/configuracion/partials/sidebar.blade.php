<div
    class="sticky border-r border-gray-950/5 top-14 z-10 flex h-full max-h-[calc(100dvh---spacing(14))] flex-col bg-white">
    <div class="flex-1 overflow-y-auto p-6" data-autoscroll="true">
        <ul class="flex flex-col gap-8" role="list">
            <li>
                <ul class="flex flex-col gap-" role="list">
                    <h3 class="font-mono text-sm/6 font-medium tracking-widest text-gray-500 uppercase sm:text-xs/6">
                        Conceptos</h3>

                        <ul class="flex flex-col gap-2 border-l border-[color-mix(in_oklab,var(--color-gray-950),white_90%)]">

                            @can('concepto ver')
                            <li>
                                <a @if (request()->is('admin/configuracion/conceptos')) aria-current="true" @endif
                                    class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                                    href="{{ route('conceptos.index') }}">
                                    {{-- Agregar icono con span o i --}}
                                    Listar
                                </a>
                            </li>
                            @endcan

                            @can('concepto crear')
                            <li>
                                <a @if (request()->is('admin/configuracion/conceptos/create')) aria-current="true" @endif
                                    class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                                    href="{{ route('conceptos.create') }}">
                                    Crear
                                </a>
                            </li>
                            @endcan
                        </ul>

                </ul>
            </li>
            <li>
                <ul class="flex flex-col gap-3" role="list">
                    <h3 class="font-mono text-sm/6 font-medium tracking-widest text-gray-500 uppercase sm:text-xs/6">
                        Roles</h3>

                    <ul
                        class="flex flex-col gap-2 border-l border-[color-mix(in_oklab,var(--color-gray-950),white_90%)]">




                        @can('rol ver')
                            <li>
                                <a @if (request()->is('admin/configuracion/roles')) aria-current="true" @endif
                                    class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                                    href="{{ route('roles.index') }}">
                                    Listar
                                </a>
                            </li>
                        @endcan
                        @can('rol crear')
                            <li>
                                <a @if (request()->is('admin/configuracion/roles/create')) aria-current="true" @endif
                                    class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                                    href="{{ route('roles.create') }}">
                                    Crear
                                </a>
                            </li>
                        @endcan
                    </ul>
                </ul>
            </li>
            <li>
                <ul class="flex flex-col gap-3" role="list">
                    <h3 class="font-mono text-sm font-medium tracking-widest text-gray-500 uppercase sm:text-xs/6">
                        Departamentos</h3>

                    <ul class="flex flex-col gap-2 border-l border-[color-mix(in_oklab,var(--color-gray-950),white_90%)]"
                        role="list">


                        @can('departamento ver')
                            <li>
                                <a @if (request()->is('admin/configuracion/departamentos')) aria-current="true" @endif
                                    class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                                    href="{{ route('departamentos.index') }}">
                                    Listar
                                </a>
                            </li>
                        @endcan
                        @can('departamento crear')
                            <li>
                                <a @if (request()->is('admin/configuracion/departamentos/create')) aria-current="true" @endif
                                    class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                                    href="{{ route('departamentos.create') }}">
                                    Crear
                                </a>
                            </li>
                        @endcan
                    </ul>
                </ul>
            </li>


            <li>
                <ul class="flex flex-col gap-3" role="list">
                    <h3 class="font-mono text-sm/6 font-medium tracking-widest text-gray-500 uppercase sm:text-xs/6">
                        Cargos</h3>
                    <ul class="flex flex-col gap-2 border-l border-[color-mix(in_oklab,var(--color-gray-950),white_90%)]"
                        role="list">

                        @can('cargo ver')
                            <li>
                                <a @if (request()->is('admin/configuracion/cargos')) aria-current="true" @endif
                                    class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                                    href="{{ route('cargos.index') }}">
                                    Listar
                                </a>
                            </li>
                        @endcan
                        @can('cargo crear')
                            <li>
                                <a @if (request()->is('admin/configuracion/cargos/create')) aria-current="true" @endif
                                    class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                                    href="{{ route('cargos.create') }}">
                                    Crear
                                </a>
                            </li>
                        @endcan
                    </ul>
                </ul>
            </li>

            <li>
                <ul class="flex flex-col gap-3" role="list">
                    <h3 class="font-mono text-sm/6 font-medium tracking-widest text-gray-500 uppercase sm:text-xs/6">
                        Generar</h3>
                    <ul class="flex flex-col gap-2 border-l border-[color-mix(in_oklab,var(--color-gray-950),white_90%)]"
                        role="list">

                        @can('movimiento crear')
                            <li class="-ml-px flex flex-col items-start gap-2">
                                <a @if (request()->is('admin/configuracion/movimientos/generar')) aria-current="true" @endif
                                    class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                                    href="{{ route('movimientos.generarForm') }}">
                                    Movimientos
                                </a>
                            </li>
                        @endcan
                        @can('liquidacion crear')
                            <li class="-ml-px flex flex-col items-start gap-2">
                                <a @if (request()->is('admin/configuracion/liquidacion/generar')) aria-current="true" @endif
                                    class="inline-block border-l border-transparent pl-5 text-base/8 text-gray-600 hover:border-gray-950/25 hover:text-gray-950 aria-[current]:border-gray-950 aria-[current]:font-semibold aria-[current]:text-gray-950 sm:pl-4 sm:text-sm/6"
                                    href="{{ route('liquidacion.generarForm') }}">
                                    Liquidaciones
                                </a>
                            </li>
                        </ul>
                    @endcan
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
        <p class="text-sm text-gray-500">
            Los roles permiten limitar las acciones de los usuarios.
        </p>
        <p class="text-sm text-gray-500">
            Administre los permisos de cada rol y asigne un rol al usuario
        </p>
    </div>
</div>
