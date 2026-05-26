@extends('layout.layout')

@section('content')

{{-- ══════════════════ PAGE INTRO ══════════════════ --}}
<section class="bg-white border-b border-slate-100 py-12 px-4">
    <div class="max-w-5xl mx-auto">
        <div class="flex flex-col md:flex-row items-center gap-10 md:gap-16">

            {{-- Left: Text --}}
            <div class="flex-1 text-left">
                <span class="inline-block text-green-600 text-[11px] tracking-[0.35em] uppercase font-semibold mb-4">
                    Who Are We?
                </span>
                <h2 class="font-playfair text-blue-950 text-3xl sm:text-4xl md:text-5xl font-bold leading-tight mb-5">
                    The Legislative Body<br class="hidden sm:block"> of Hilongos
                </h2>
                <div class="flex items-center gap-2 mb-5">
                    <span class="w-10 h-[3px] bg-green-500 block"></span>
                    <span class="w-3 h-[3px] bg-green-300 block"></span>
                </div>
                <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-4">
                    The <strong class="text-blue-950 font-semibold">Sangguniang Bayan</strong> is the legislative
                    body responsible for creating ordinances, resolutions, and policies that support the development
                    and governance of the town.
                </p>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Serving the people of <strong class="text-blue-950 font-medium">Hilongos, Leyte</strong> through
                    principled governance, transparent lawmaking, and responsive public service.
                </p>
            </div>


            {{-- Right: Image --}}
            <div class="flex-1 w-full">
                <img src="{{ asset('images/Sb.jpg') }}"
                    class="w-full h-auto object-contain block"
                    alt="SB Members Photo">
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════ POWERS & FUNCTIONS ══════════════════ --}}
<section class="bg-slate-50 py-12 px-4">
    <div class="max-w-5xl mx-auto">

        <div class="mb-8">
            <span class="inline-block text-green-600 text-[11px] tracking-[0.35em] uppercase font-semibold mb-2">
                Mandate
            </span>
            <h3 class="font-playfair text-blue-950 text-2xl sm:text-3xl font-bold">
                Powers &amp; Functions
            </h3>
        </div>

        @php
            $powers = [
                [
                    'icon'  => 'M12 3h.393a7.5 7.5 0 0 0 7.92 6.638A8.5 8.5 0 0 1 12 21a8.5 8.5 0 0 1-8.313-11.362 7.5 7.5 0 0 0 7.92-6.638H12z',
                    'label' => 'Legislation',
                    'text'  => 'Enact ordinances and approve resolutions for effective municipal governance',
                ],
                [
                    'icon'  => 'M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 0 2-2h2a2 2 0 0 0 2 2',
                    'label' => 'Budgeting',
                    'text'  => 'Approve municipal and barangay budgets and development plans',
                ],
                [
                    'icon'  => 'M3 21h18M5 21V7l8-4 8 4v14M9 21V11h6v10',
                    'label' => 'Regulation',
                    'text'  => 'Regulate land use, businesses, and public utilities',
                ],
                [
                    'icon'  => 'M3.055 11H5a2 2 0 0 1 2 2v1a2 2 0 0 0 2 2 2 2 0 0 1 2 2v2.945M8 3.935V5.5A2.5 2.5 0 0 0 10.5 8h.5a2 2 0 0 1 2 2 2 2 0 0 0 4 0 2 2 0 0 1 2-2h1.064M15 20.488V18a2 2 0 0 1 2-2h3.064',
                    'label' => 'Public Safety',
                    'text'  => 'Provide for public safety, environmental protection, and infrastructure development',
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($powers as $power)
            <div class="bg-white border border-slate-200 p-5 flex flex-col gap-3 hover:border-green-400 hover:shadow-sm transition-all duration-200">
                <div class="w-10 h-10 bg-green-50 border border-green-200 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $power['icon'] }}" />
                    </svg>
                </div>
                <div>
                    <p class="text-blue-950 font-semibold text-xs uppercase tracking-wider mb-1">{{ $power['label'] }}</p>
                    <p class="text-slate-600 text-sm leading-relaxed">{{ $power['text'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ══════════════════ MAJOR ACCOMPLISHMENTS ══════════════════ --}}
<section class="bg-blue-950 py-14 px-4">
    <div class="max-w-5xl mx-auto">

        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 mb-10">
            <div>
                <span class="inline-block text-green-300 text-[11px] tracking-[0.35em] uppercase font-semibold mb-2">
                    Track Record
                </span>
                <h3 class="font-playfair text-white text-2xl sm:text-3xl md:text-4xl font-bold">
                    Major Accomplishments
                </h3>
            </div>
            <p class="text-white/40 text-xs sm:text-sm sm:text-right max-w-xs">
                Key ordinances enacted across multiple sectors
            </p>
        </div>

        @php
            $accomplishments = [
                [
                    'category'   => 'Health, Nutrition & Sanitation',
                    'ordinances' => [
                        ['no' => '2022-13',    'title' => 'Health and Sanitation Code of Hilongos'],
                        ['no' => '2022-04-NS', 'title' => 'Municipal Epidemiology and Surveillance Unit (MESU)'],
                        ['no' => '2023-04',    'title' => 'Dugo Ko, Kinabuhi Mo'],
                        ['no' => '2023-11',    'title' => 'Prohibiting the Dispensing, Selling and Reselling of Drugs and other Pharmaceutical Products'],
                        ['no' => '2023-18',    'title' => 'Animal Bite Treatment Center'],
                        ['no' => '2024-06',    'title' => 'Refrigerator Garden Program'],
                        ['no' => '2024-09',    'title' => 'PhilHealth Konsulta Package Fund'],
                        ['no' => '2024-20',    'title' => 'BHW and BNS Incentive Ordinance'],
                    ],
                ],
                [
                    'category'   => 'Education',
                    'ordinances' => [
                        ['no' => '2022-06-NS', 'title' => 'Amending Scholarship Program'],
                    ],
                ],
                [
                    'category'   => 'Youth & Development',
                    'ordinances' => [
                        ['no' => '2023-09', 'title' => 'Kabataan Kontra Krimen, Droga At Terrorismo (KK2DAT)'],
                        ['no' => '2024-10', 'title' => 'Adopting the Official Seal of the Pambayang Pederasyon ng Sangguniang Kabataan'],
                        ['no' => '2024-23', 'title' => 'Establishing the Municipal Teen Center'],
                    ],
                ],
                [
                    'category'   => 'Business Friendliness & Competitiveness',
                    'ordinances' => [
                        ['no' => '2022-02-NS', 'title' => "Rental and other Fees for the Use of the two-storey Traveller's Lounge"],
                        ['no' => '2022-08-NS', 'title' => "Seafaring's Environmental Fee"],
                        ['no' => '2023-02',    'title' => 'Extending the Deadline for the Payment of Business Permits'],
                        ['no' => '2023-16',    'title' => 'Revenue Code of Hilongos'],
                        ['no' => '2024-16',    'title' => 'Buy Local Go Lokal'],
                        ['no' => '2024-18',    'title' => 'Collection of Barangay Clearance Fees and Integration to BPLS'],
                        ['no' => '2025-09',    'title' => 'Real Property Tax Amnesty'],
                    ],
                ],
                [
                    'category'   => 'Tourism, Culture & Arts',
                    'ordinances' => [
                        ['no' => '2024-04', 'title' => 'Anibong Festival'],
                        ['no' => '2025-10', 'title' => 'Local Cultural Properties'],
                    ],
                ],
                [
                    'category'   => 'Environmental Management',
                    'ordinances' => [
                        ['no' => '2022-08-NS', 'title' => "Seafaring Passenger's Environment Fee"],
                    ],
                ],
                [
                    'category'   => 'Disaster Preparedness',
                    'ordinances' => [
                        ['no' => '2024-02', 'title' => 'Early Warning System Mechanism'],
                    ],
                ],
                [
                    'category'   => 'Social Services',
                    'ordinances' => [
                        ['no' => '2024-12', 'title' => 'MAIN Desk Ordinance'],
                        ['no' => '2025-07', 'title' => 'Anti-OSAEC / CSAEM Ordinance'],
                    ],
                ],
                [
                    'category'   => 'Public Safety & Order',
                    'ordinances' => [
                        ['no' => '2023-10', 'title' => 'Hilongos CCTV Ordinance'],
                        ['no' => '2024-15', 'title' => 'Institutionalizing CBDRP'],
                    ],
                ],
                [
                    'category'   => 'Finance',
                    'ordinances' => [
                        ['no' => '2022-03-NS', 'title' => 'Supplemental Budget No. 03 CY 2022'],
                        ['no' => '2022-09-NS', 'title' => 'Annual Budget 2022-09'],
                        ['no' => '2023-16',    'title' => 'Revenue Code of Hilongos'],
                        ['no' => '2024-27',    'title' => 'Supplemental Budget No. 2024-27'],
                        ['no' => '2025-09',    'title' => 'Real Property Tax Amnesty Ordinance of 2025'],
                    ],
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($accomplishments as $item)
            <div class="border border-white/10 bg-white/5 p-5">
                <h4 class="text-green-300 text-[10px] tracking-[0.25em] uppercase font-bold mb-3 pb-2 border-b border-white/10">
                    {{ $item['category'] }}
                </h4>
                <table class="w-full">
                    <thead>
                        <tr class="text-white/30 text-[10px] uppercase tracking-wider">
                            <th class="text-left pb-2 pr-4 w-28 font-normal">Ord. No.</th>
                            <th class="text-left pb-2 font-normal">Title</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($item['ordinances'] as $ord)
                        <tr class="border-t border-white/5 group">
                            <td class="py-2 pr-4 text-green-400 font-mono text-xs align-top whitespace-nowrap">
                                {{ $ord['no'] }}
                            </td>
                            <td class="py-2 text-white/65 text-xs leading-snug align-top group-hover:text-white/90 transition-colors">
                                {{ $ord['title'] }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach
        </div>

        {{-- Award Banner --}}
        <div class="mt-6 bg-green-500/10 border border-green-400/25 p-5 flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
            <div class="w-12 h-12 flex-shrink-0 bg-green-500/20 border border-green-400/30 flex items-center justify-center text-2xl">
                🏆
            </div>
            <div>
                <p class="text-green-300 text-[10px] tracking-[0.3em] uppercase font-semibold mb-1">Recognition</p>
                <p class="text-white font-semibold text-sm sm:text-base leading-snug">
                    3rd Runner Up — 2023 Local Legislative Award Regional Onsite Validation
                </p>
                <p class="text-white/40 text-xs mt-0.5">1st–3rd Class Municipalities Category</p>
            </div>
        </div>

    </div>
</section>

{{-- ══════════════════ MAJOR TARGETS ══════════════════ --}}
<section class="bg-slate-50 py-14 px-4">
    <div class="max-w-5xl mx-auto">

        <div class="mb-10">
            <span class="inline-block text-green-600 text-[11px] tracking-[0.35em] uppercase font-semibold mb-2">
                Looking Ahead
            </span>
            <h3 class="font-playfair text-blue-950 text-2xl sm:text-3xl md:text-4xl font-bold">
                Major Targets in the Next Three Years
            </h3>
        </div>

        @php
            $targets = [
                'Social Protection' => [
                    'Ordinance Recognizing and Valuing Unpaid Care and Domestic Work',
                    'Ordinance Revising / Amending the Gender and Development Code of 2019',
                    "Ordinance Revising / Amending the Municipal Children's Code",
                    'Ordinance Adopting the New Childhood Care and Development and Converting Day Care Services to Childhood Development Centers',
                    'Ordinance Amending the VAWC Desk Establishment in every Barangay',
                    'Ordinance Enacting the Hilongos Child Protection Policy Ordinance',
                    'Ordinance Institutionalizing Programs for Solo Parents and their Children',
                ],
                'Health' => [
                    'Ordinance Banning Smoking and Vaping in Public Places and Private Establishments',
                    'Ordinance Institutionalizing Barangay Emergency Rescue Team (BERT) in all 51 Barangays',
                    'Ordinance Providing for a Community Based Mental Health Program',
                    'Ordinance Amending the Business Permit and Licensing Office Establishment',
                ],
                'Disaster Management' => [
                    'Ordinance Establishing the Pre-Emptive and Forced Evacuation System',
                    'Ordinance Implementing Emergency Relief and Protection for Children During Disasters',
                ],
                'Education' => [
                    'Ordinance Granting Cash Incentives to Hilongosnons who Excelled in Sports and Academic Competitions',
                ],
                'Youth' => [
                    'Ordinance Prohibiting the Sale of Alcoholic Beverages to Persons Below 18 years of age',
                    'Municipal Ordinance Amending Scholarship Program for Return Service Agreement',
                    'Ordinance Institutionalizing Angat Kabataang Hilongosnon (Palarong Pambayan)',
                ],
                'Business' => [
                    'Ordinance Enacting the Market Code of Hilongos',
                    'Ordinance Amending the Hilongos Investment Code of 2018',
                    'Ordinance Enacting the Schedule of Market Values for Real Property',
                    'Ordinance Amending the Revenue Code',
                ],
                'Tourism' => [
                    'Ordinance Supporting the Development of the Film Industry in Hilongos',
                ],
                'Environmental Management' => [
                    'Ordinance Prescribing Guidelines for Sanitary Landfill Operation',
                    'Ordinance Requiring Tree Planting as Requirement for Marriage License Application',
                    'Ordinance Declaring a Monthly "No Plastic Day"',
                    'Ordinance Creating the Municipal Environment and Natural Resources Office',
                    'Ordinance for Operation and Management of Materials Recovery Facility',
                    'Ordinance Institutionalizing Arbor Day in the Municipality of Hilongos',
                    'Ordinance Enacting the Environment Code of Hilongos',
                    'Ordinance Institutionalizing Eco-Bricking As A Sustainable Waste-Reduction Strategy',
                    'Ordinance Establishing the Hilongos Wildlife and Trafficking Protection Program',
                    'Ordinance Establishing Mangroves and Beach Forest Protection',
                    'Ordinance Declaring a Marine Protected Area in Brgy. Naval',
                ],
                'Public Safety' => [
                    'Ordinance on Flammable and Combustible Liquids for Technology Solution Retail Outlets',
                    'Ordinance Amending the Anti-Dangling Wire Ordinance',
                    'Ordinance Enacting the Municipal Traffic Code',
                    'Ordinance Establishing the Hilongos Police Auxiliary Unit',
                    'Ordinance Establishing the Hilongos Human Rights Action Center',
                    'Ordinance Regulating the Use of Electrical Tricycles / E-Trikes as Public Transportation',
                ],
                'Others' => [
                    'Ordinance Institutionalizing Participatory Governance',
                    'Ordinance Establishing the General Services Unit (GSU)',
                    'Ordinance Institutionalizing a Grievance and Redress System',
                    'Ordinance Adopting the Data Privacy Act of 2012',
                    'Ordinance Creating Various Positions',
                    'Ordinance Establishing a System of Awards and Recognition for Outstanding Barangays',
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($targets as $sector => $items)
            <div class="bg-white border border-slate-200 p-5 flex flex-col hover:border-green-400 hover:shadow-sm transition-all duration-200">
                <div class="flex items-center gap-2 mb-3 pb-2 border-b-2 border-green-500">
                    <h4 class="text-blue-950 text-[10px] tracking-[0.2em] uppercase font-bold">
                        {{ $sector }}
                    </h4>
                    <span class="ml-auto text-[10px] font-mono text-green-600 bg-green-50 px-1.5 py-0.5 border border-green-200">
                        {{ count($items) }}
                    </span>
                </div>
                <ul class="space-y-1.5 flex-1">
                    @foreach ($items as $item)
                    <li class="flex items-start gap-2 text-slate-600 text-xs leading-snug">
                        <span class="text-green-500 flex-shrink-0 mt-0.5 font-bold">▸</span>
                        <span>{{ $item }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ══════════════════ CHALLENGES & SUGGESTED ACTIONS ══════════════════ --}}
<section class="bg-blue-950 py-14 px-4">
    <div class="max-w-5xl mx-auto">

        <div class="mb-10 text-center">
            <span class="inline-block text-green-300 text-[11px] tracking-[0.35em] uppercase font-semibold mb-2">
                Governance Outlook
            </span>
            <h3 class="font-playfair text-white text-2xl sm:text-3xl md:text-4xl font-bold">
                Challenges &amp; Suggested Actions
            </h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Challenges --}}
            <div class="border border-white/10 bg-white/5 p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-red-500/20 border border-red-400/30 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <h4 class="text-white font-playfair text-lg font-bold">Major Challenges</h4>
                </div>
                <div class="space-y-4">
                    <div class="border-l-2 border-red-400/60 pl-4">
                        <p class="text-white text-sm font-semibold mb-1">Funding Constraints</p>
                        <p class="text-white/50 text-xs leading-relaxed">Lack of adequate funding for legislative programs and initiatives.</p>
                    </div>
                    <div class="border-l-2 border-red-400/60 pl-4">
                        <p class="text-white text-sm font-semibold mb-1">Risk Mitigation</p>
                        <p class="text-white/50 text-xs leading-relaxed">Lack of trained legislative staff to manage and mitigate institutional risks.</p>
                    </div>
                </div>
            </div>

            {{-- Suggested Actions --}}
            <div class="border border-white/10 bg-white/5 p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-green-500/20 border border-green-400/30 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="text-white font-playfair text-lg font-bold">Suggested Actions</h4>
                </div>
                @php
                    $actions = [
                        'Codification of General Ordinances',
                        'Establish a Paperless Sangguniang Bayan System',
                        'Knowledge Exchange with National and International Legislative Bodies',
                        'Creation of Local Legislative Staff Officer V position',
                        'Enactment of Municipal Ordinances aligned with the "Bagong Pilipinas" Philippine Development Plan 2023–2028',
                    ];
                @endphp
                <ul class="space-y-3">
                    @foreach ($actions as $i => $action)
                    <li class="flex items-start gap-3">
                        <span class="flex-shrink-0 w-5 h-5 bg-green-500/20 border border-green-400/40 text-green-300 text-[10px] font-bold flex items-center justify-center mt-0.5">
                            {{ $i + 1 }}
                        </span>
                        <span class="text-white/70 text-sm leading-snug">{{ $action }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</section>

@endsection
