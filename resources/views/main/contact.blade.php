@extends('layout.layout')

@section('content')

<style>
.grecaptcha-badge {
    display: none !important;
}
</style>

<section class="bg-slate-50 py-16 px-4 sm:px-6 lg:px-12">

    <div class="max-w-5xl mx-auto">

        <!-- SINGLE CARD -->
        <div class="bg-gradient-to-br from-blue-900 via-blue-800 to-green-900 text-white rounded-2xl shadow-xl p-8 md:p-12">

            <!-- HEADER -->
            <div class="text-center mb-10">

                <p class="text-green-300 text-xs tracking-[0.3em] uppercase">
                    Contact Us
                </p>

                <h1 class="text-4xl md:text-5xl font-playfair font-bold mt-2">
                    Get in Touch
                </h1>

                <p class="text-white/70 mt-3 text-sm max-w-2xl mx-auto">
                    Reach out to the Sangguniang Bayan of Hilongos, Leyte for inquiries, assistance, and public concerns.
                </p>

            </div>

            <!-- GRID CONTENT -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                <!-- CONTACT INFO -->
                <div>

                    <h2 class="text-xl font-semibold text-green-300 mb-5 uppercase tracking-wider">
                        Office Information
                    </h2>

                    <div class="space-y-6 text-sm text-white/90">

                        <div>
                            <p class="text-green-300 font-semibold">Email</p>
                            <p>sblegis@gmail.com</p>
                        </div>

                        <div>
                            <p class="text-green-300 font-semibold">Phone</p>
                            <p>+63 987 654 3210</p>
                        </div>

                        <div>
                            <p class="text-green-300 font-semibold">Address</p>
                            <p>
                                Legislative Building, Sangguniang Bayan<br>
                                Brgy. Western, Hilongos, Leyte
                            </p>
                        </div>

                    </div>

                </div>

                <!-- FORM -->
                <div>

                    <h2 class="text-xl font-semibold text-green-300 mb-5 uppercase tracking-wider">
                        Send Message
                    </h2>

                    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                    <form class="space-y-4" method="POST" action="{{ route('contact.store') }}">
                        @csrf

                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        <input type="text" name="name"
                            class="w-full p-3 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Full Name" required>

                        <input type="text" name="phone"
                            class="w-full p-3 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Mobile Number">

                        <input type="email" name="email"
                            class="w-full p-3 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Email Address" required>

                        <textarea rows="4" name="message"
                            class="w-full p-3 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Your Message" required></textarea>

                            <p class="text-xs text-slate-500 mt-3 text-center">
                                Protected by reCAPTCHA &mdash;
                                <a href="https://policies.google.com/privacy" class="underline">Privacy</a> &amp;
                                <a href="https://policies.google.com/terms" class="underline">Terms</a>
                            </p>

                        <button
                            class="w-full bg-green-600 hover:bg-green-500 text-white font-bold py-3 rounded-md transition-all g-recaptcha"
                            data-sitekey="{{ config('services.recaptcha.site_key') }}"
                            data-callback="onSubmit"
                            data-action="submit">
                            Send Message
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</section>

<script>
function onSubmit(token) {
    document.querySelector('form').submit();
}
</script>

@endsection
