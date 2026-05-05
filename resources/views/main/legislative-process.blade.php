@extends('layout.layout')

@section('content')
<div class="bg-slate-50 min-h-screen py-16 px-4 sm:px-8">

    <div class="max-w-5xl mx-auto">

        <!-- Title -->
        <h1 class="text-3xl sm:text-4xl font-extrabold text-center text-blue-900 mb-16 tracking-wide">
            LEGISLATIVE FLOWCHART
        </h1>

        <div class="space-y-8">

            @php
                $steps = [
                    'Filing of Proposed Ordinance / Resolution',
                    'First Reading / Referral to Appropriate Committee',
                    'Public Hearing / Committee Meeting / Action',
                    'Committee Report',
                    'Proposed Measures for Inclusion in the Calendar of Business',
                    'Second Reading',
                    'Printing of Final Draft by the Secretary to the Sangguniang',
                    'Third and Final Reading',
                    'Signing of Enacted Ordinance and Approved Resolution',
                    "10-Day Period for Mayor's Approval",
                    '3-Day Submission to Sangguniang Panlalawigan',
                    'Review Period (30–60 Days)',
                ];
            @endphp

            @foreach ($steps as $index => $step)

                @php
                    $isEven = $index % 2 === 0;
                @endphp

                <div class="flex items-center {{ $isEven ? 'flex-row' : 'flex-row-reverse' }} gap-5 group">

                    <!-- Number -->
                    <div class="flex-shrink-0 w-14 h-14 sm:w-16 sm:h-16 flex items-center justify-center
                        rounded-full bg-blue-800 text-white font-extrabold text-lg sm:text-xl
                        group-hover:bg-green-700 transition shadow-md">
                        {{ $index + 1 }}
                    </div>

                    <!-- Step -->
                    <div class="flex-1 bg-white border border-slate-200 rounded-full px-6 sm:px-10 py-5 sm:py-6
                        text-sm sm:text-base font-semibold text-blue-900
                        group-hover:bg-green-800 group-hover:text-white
                        transition-all duration-300 shadow-sm
                        {{ $isEven ? 'text-left' : 'text-right' }}">

                        {{ $step }}

                    </div>

                </div>

            @endforeach

        </div>

    </div>
</div>
@endsection
