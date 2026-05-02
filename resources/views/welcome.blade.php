@extends('layout.layout')

@section('content')

<div class="bg-slate-100 py-4 sm:py-6 m-2 sm:m-4 lg:m-6 rounded-xl shadow-sm">

    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6">

        <h2 class="text-xl sm:text-2xl md:text-3xl font-playfair font-bold text-blue-900 mb-5 sm:mb-6">
            Latest Facebook Updates
        </h2>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-5 lg:gap-6">

            {{-- LEFT SIDE : FACEBOOK --}}
            <div class="bg-white rounded-xl shadow overflow-hidden">

                <iframe
                    src="https://www.facebook.com/plugins/page.php?href=https://www.facebook.com/SBHilongos/&tabs=timeline&width=500&height=800&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true"
                    class="w-full"
                    height="800"
                    style="border:none; overflow:hidden; display:block;"
                    scrolling="yes"
                    frameborder="0"
                    allowfullscreen="true"
                    allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
                </iframe>

            </div>

            {{-- RIGHT SIDE : IMAGE + DESCRIPTION --}}
            <div class="bg-white rounded-xl shadow p-4 sm:p-5 lg:p-6 flex flex-col">

                <img src="{{ asset('images/legis-building.jpg') }}"
                    class="w-full h-56 sm:h-72 md:h-80 lg:h-[420px] object-cover rounded-lg mb-4 sm:mb-5"
                    alt="Legislative Building">

                <h3 class="text-xl sm:text-2xl md:text-3xl font-playfair font-bold text-blue-900 mb-3">
                    Hilongos Legislative Building
                </h3>

                <p class="text-gray-700 leading-7 sm:leading-8 text-justify text-sm sm:text-[15px] md:text-base">
                    The Hilongos Legislative Building stands as a symbol of local democracy,
                    offering a structured environment where the town's legislative body crafts
                    policies for the community's welfare.

                    Its strategic position near the municipal hall ensures seamless coordination
                    between the executive and legislative branches of the local government.

                    By providing modern facilities for sessions and committee meetings, the building
                    plays a crucial role in transparent, responsive, and efficient governance for
                    the people of Hilongos.
                </p>

            </div>

        </div>

    </div>

</div>

@endsection
