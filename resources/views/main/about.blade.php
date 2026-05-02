@extends('layout.layout')

@section('content')
<section class="py-20 space-y-20 overflow-hidden">

    <!-- ══════════════════ VISION (BLUE) ══════════════════ -->
    <div class="relative">

        <!-- Background Shape -->
        <div class="absolute inset-0 bg-blue-900 rounded-r-[120px]"></div>

        <div class="relative max-w-6xl mx-auto px-6 py-16 grid md:grid-cols-2 gap-10 items-center">

            <!-- Image LEFT -->
            <div>
                <img src="{{ asset('images/legis-building.jpg') }}"
                    class="w-full h-[320px] md:h-[380px] object-cover rounded-xl shadow-lg">
            </div>

            <!-- Text RIGHT -->
            <div class="text-white">
                <p class="text-green-300 text-xs uppercase tracking-widest mb-2">
                    Our Vision
                </p>

                <h2 class="text-3xl md:text-4xl font-playfair font-bold mb-4">
                    Vision
                </h2>

                <p class="leading-relaxed text-white/90">
                    A transparent, accountable, and people-centered legislative office committed to crafting responsive
                    and progressive laws that promote sustainable development, social justice, and improved quality of life.
                </p>
            </div>

        </div>
    </div>


    <!-- ══════════════════ MISSION (GREEN) ══════════════════ -->
    <div class="relative">

        <!-- Background Shape -->
        <div class="absolute inset-0 bg-green-900 rounded-l-[120px]"></div>

        <div class="relative max-w-6xl mx-auto px-6 py-16 grid md:grid-cols-2 gap-10 items-center">

            <!-- Text LEFT -->
            <div class="text-white">
                <p class="text-green-300 text-xs uppercase tracking-widest mb-2">
                    Our Mission
                </p>

                <h2 class="text-3xl md:text-4xl font-playfair font-bold mb-4">
                    Mission
                </h2>

                <p class="leading-relaxed text-white/90">
                    To efficiently enact ordinances and resolutions that address community needs, uphold democratic principles,
                    and strengthen collaboration between government and citizens.
                </p>
            </div>

            <!-- Image RIGHT -->
            <div>
                <img src="{{ asset('images/legis-building.jpg') }}"
                    class="w-full h-[320px] md:h-[380px] object-cover rounded-xl shadow-lg">
            </div>

        </div>
    </div>

</section>

<section class="bg-blue-900 py-16">

    <div class="text-center mb-10">
        <p class="text-green-300 text-xs uppercase tracking-widest">Location</p>

        <h2 class="text-3xl font-playfair text-white font-bold">
            Legislative Building
        </h2>
    </div>

    <div class="max-w-5xl mx-auto px-4">
        <div class="rounded-xl overflow-hidden shadow-xl border-4 border-green-400/30">

            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3922.314987654321!2d124.7447686!3d10.3717315!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33076f38c5ea9443%3A0xc1f118b5152ba196!2sLegislative%20Building!5e0!3m2!1sen!2sph!4v1714440000000!5m2!1sen!2sph" class="rounded-md w-full h-[250px] sm:h-[350px] md:h-[400px] lg:h-[450px] xl:h-[500px]" style="border:0;" allowfullscreen="" loading="lazy">
            </iframe>

        </div>
    </div>

</section>
@endsection
