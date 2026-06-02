<x-app-layout>
    <style>
        /* Fallback visual for selected items if Tailwind classes are not applied at runtime */
        .selected {
            border-color: #6366f1 !important; /* indigo-500 */
            background-color: #eef2ff !important; /* indigo-50 */
            color: #1f2937 !important; /* slate-800 */
        }
        @media (prefers-color-scheme: dark) {
            .selected {
                border-color: #6366f1 !important;
                background-color: #0f172a !important; /* dark indigo-ish */
                color: #e6eef8 !important;
            }
        }
    </style>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                    Dashboard Pencarian Karir
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                    Menampilkan data karir dari database dan memulai pencarian yang sesuai dengan pendidikan, skill, spesialisasi, dan sertifikat Anda.
                </p>
            </div>

            <button id="open-search-modal" type="button" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Mulai Pencarian Pekerjaan
            </button>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="grid gap-4 xl:grid-cols-4 lg:grid-cols-2 sm:grid-cols-2">
                <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-700/80 dark:bg-slate-900">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Karir</p>
                    <p class="mt-4 text-3xl font-semibold text-slate-900 dark:text-slate-100">{{ $careers->count() }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-700/80 dark:bg-slate-900">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Pilihan Pendidikan</p>
                    <p class="mt-4 text-3xl font-semibold text-slate-900 dark:text-slate-100">{{ $educations->count() }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-700/80 dark:bg-slate-900">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Skill Tersedia</p>
                    <p class="mt-4 text-3xl font-semibold text-slate-900 dark:text-slate-100">{{ $skills->count() }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-700/80 dark:bg-slate-900">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Spesialisasi & Sertifikat</p>
                    <p class="mt-4 text-3xl font-semibold text-slate-900 dark:text-slate-100">{{ $specializations->count() + $certifications->count() }}</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                @foreach ($careers->take(6) as $career)
                    <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md dark:border-slate-700/80 dark:bg-slate-900">
                        <div class="flex items-center justify-between gap-4">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">{{ $career->career_name }}</h3>
                            <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-200">Karir</span>
                        </div>
                        <p class="mt-4 text-sm leading-6 text-slate-600 dark:text-slate-300">Jelajahi karir ini dan lihat opsi teratas berdasarkan kombinasi skill, spesialisasi, pendidikan, dan sertifikat.</p>
                    </div>
                @endforeach
            </div>

            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-700/80 dark:bg-slate-900">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Hasil Pencarian</h3>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Hasil akan terurut berdasarkan kecocokan dengan data yang Anda pilih.</p>
                    </div>
                </div>

                @if ($searchResults->isNotEmpty())
                    <div class="mt-6 space-y-4">
                        @foreach ($searchResults as $result)
                            <div class="rounded-3xl border border-slate-200/80 bg-slate-50 p-5 dark:border-slate-700/80 dark:bg-slate-950">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <h4 class="font-semibold text-slate-900 dark:text-slate-100">{{ $result->career_name }}</h4>
                                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Skor kecocokan: <span class="font-semibold text-slate-900 dark:text-slate-100">{{ number_format($result->score, 2) }}</span></p>
                                    </div>
                                    <span class="inline-flex rounded-full bg-indigo-100 px-3 py-1 text-sm font-medium text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-200">Rekomendasi</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @elseif(array_filter($criteria))
                    <div class="mt-6 rounded-3xl border border-amber-200 bg-amber-50 p-6 text-amber-800 dark:border-amber-700/80 dark:bg-amber-900/10 dark:text-amber-100">
                        <p class="font-medium">Tidak ada kecocokan yang ditemukan.</p>
                        <p class="mt-2 text-sm text-amber-700 dark:text-amber-200">Coba pilih kombinasi education, skill, specialization, atau sertifikat lain untuk memperluas hasil pencarian.</p>
                    </div>
                @else
                    <div class="mt-6 rounded-3xl border border-slate-200/80 bg-slate-50 p-6 text-slate-700 dark:border-slate-700/80 dark:bg-slate-950 dark:text-slate-300">
                        <p class="font-medium">Tekan tombol &quot;Mulai Pencarian Pekerjaan&quot; untuk mengisi preferensi Anda.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="search-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4 py-10">
        <div class="w-full max-w-4xl overflow-hidden rounded-3xl bg-white text-slate-900 shadow-2xl dark:bg-slate-900 dark:text-slate-100">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5 dark:border-slate-700/80">
                <div>
                    <h3 class="text-xl font-semibold">Isi data pencarian</h3>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Ikuti langkah berikut untuk memilih kriteria dan lihat hasilnya langsung.</p>
                </div>
                <button id="close-search-modal" type="button" class="rounded-full border border-slate-200 bg-white px-3 py-2 text-slate-600 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                    Close
                </button>
            </div>

            <form method="GET" action="{{ route('dashboard') }}" id="wizard-form">
                <div class="border-b border-slate-200 bg-slate-50 px-6 py-4 dark:border-slate-700/80 dark:bg-slate-950">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-3">
                            <span id="step-label" class="rounded-full bg-indigo-600 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-white">Step 1</span>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ request()->query('education_id') ? 'Lengkapi kriteria Anda' : 'Pilih data pendidikan terlebih dahulu' }}</span>
                        </div>
                        <div class="flex flex-wrap gap-2 text-sm text-slate-500 dark:text-slate-400">
                            <span class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 shadow-sm dark:bg-slate-800">
                                Education: <strong class="text-slate-800 dark:text-slate-100">{{ optional($educations->firstWhere('education_id', request('education_id')))->education_level ?? 'Belum pilih' }}</strong>
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 shadow-sm dark:bg-slate-800">
                                Skills: <strong class="text-slate-800 dark:text-slate-100">{{ count(request('skill_ids', [])) }} dipilih</strong>
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 shadow-sm dark:bg-slate-800">
                                Specializations: <strong class="text-slate-800 dark:text-slate-100">{{ count(request('specialization_ids', [])) }} dipilih</strong>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 px-6 py-6">
                    <div data-step="1" class="step-panel">
                        <div class="space-y-4">
                            <p class="text-sm text-slate-600 dark:text-slate-400">Pilih satu pendidikan yang paling mendekati latar belakang Anda.</p>
                            <label for="education_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Education</label>
                            <select id="education_id" name="education_id" class="mt-2 block w-full rounded-3xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                                <option value="">Pilih pendidikan</option>
                                @foreach ($educations as $item)
                                    <option value="{{ $item->education_id }}" {{ request('education_id') == $item->education_id ? 'selected' : '' }}>{{ $item->education_level }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div data-step="2" class="step-panel hidden">
                        <div class="space-y-4">
                            <p class="text-sm text-slate-600 dark:text-slate-400">Klik skill yang dimiliki. Pilihan akan disorot saat dipilih.</p>
                            <div class="grid gap-3 md:grid-cols-2">
                                @foreach ($skills as $item)
                                    <button type="button" data-value="{{ $item->skill_id }}" data-group="skills" class="skill-item rounded-3xl border border-slate-200 bg-white px-4 py-3 text-left text-slate-800 shadow-sm transition hover:border-indigo-400 hover:bg-indigo-50 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:hover:border-indigo-500 dark:hover:bg-indigo-950 {{ in_array($item->skill_id, request('skill_ids', [])) ? 'selected border-indigo-500 bg-indigo-50 text-indigo-900 dark:border-indigo-500 dark:bg-indigo-950' : '' }}">
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="font-medium">{{ $item->skill_name }}</span>
                                            <span class="text-xs text-slate-500 dark:text-slate-400">Skill</span>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div data-step="3" class="step-panel hidden">
                        <div class="space-y-4">
                            <p class="text-sm text-slate-600 dark:text-slate-400">Pilih spesialisasi yang relevan dengan tujuan karir Anda.</p>
                            <div class="grid gap-3 md:grid-cols-2">
                                @foreach ($specializations as $item)
                                    <button type="button" data-value="{{ $item->specialization_id }}" data-group="specializations" class="specialization-item rounded-3xl border border-slate-200 bg-white px-4 py-3 text-left text-slate-800 shadow-sm transition hover:border-indigo-400 hover:bg-indigo-50 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:hover:border-indigo-500 dark:hover:bg-indigo-950 {{ in_array($item->specialization_id, request('specialization_ids', [])) ? 'selected border-indigo-500 bg-indigo-50 text-indigo-900 dark:border-indigo-500 dark:bg-indigo-950' : '' }}">
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="font-medium">{{ $item->specialization_name }}</span>
                                            <span class="text-xs text-slate-500 dark:text-slate-400">Spesialisasi</span>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div data-step="4" class="step-panel hidden">
                        <div class="space-y-4">
                            <p class="text-sm text-slate-600 dark:text-slate-400">Pilih satu sertifikat yang paling mewakili kemampuan Anda.</p>
                            <label for="certification_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Sertifikat</label>
                            <select id="certification_id" name="certification_id" class="mt-2 block w-full rounded-3xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                                <option value="">Pilih sertifikat</option>
                                @foreach ($certifications as $item)
                                    <option value="{{ $item->certification_id }}" {{ request('certification_id') == $item->certification_id ? 'selected' : '' }}>{{ $item->certification_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div id="skill-inputs"></div>
                    <div id="specialization-inputs"></div>
                </div>

                <div class="border-t border-slate-200 px-6 py-4 dark:border-slate-700/80">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-400">
                            <button id="prev-step" type="button" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-4 py-2 text-sm text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">Back</button>
                            <button id="next-step" type="button" class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Next</button>
                        </div>
                        <div class="text-sm text-slate-500 dark:text-slate-400">Step <span id="current-step-number">1</span> dari 4</div>
                    </div>
                </div>

                <div id="popup-results" class="max-h-96 overflow-y-auto border-t border-slate-200 bg-slate-50 px-6 py-6 dark:border-slate-700/80 dark:bg-slate-950">
                    <h4 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Hasil Pencarian</h4>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Hasil akan tampil di bawah setelah Anda menyelesaikan pilihan dan menekan tombol Next di step terakhir.</p>

                    @if ($searchResults->isNotEmpty())
                        <div class="mt-5 grid gap-4 lg:grid-cols-2">
                            @foreach ($searchResults as $result)
                                <div class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700/80 dark:bg-slate-900">
                                    <div class="flex items-center justify-between gap-3">
                                        <h5 class="font-semibold text-slate-900 dark:text-slate-100">{{ $result->career_name }}</h5>
                                        <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-200">Skor {{ number_format($result->score, 2) }}</span>
                                    </div>
                                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Rekomendasi berdasarkan kombinasi pilihan Anda.</p>
                                </div>
                            @endforeach
                        </div>
                    @elseif(array_filter($criteria))
                        <div class="mt-5 rounded-3xl border border-amber-200 bg-amber-50 p-5 text-amber-800 dark:border-amber-700/80 dark:bg-amber-900/10 dark:text-amber-100">
                            Belum ada hasil. Silakan cek kembali pilihan Anda atau lanjutkan untuk submit pencarian.
                        </div>
                    @else
                        <div class="mt-5 rounded-3xl border border-slate-200 bg-white p-5 text-slate-700 dark:border-slate-700/80 dark:bg-slate-950 dark:text-slate-300">
                            Hasil akan muncul di sini setelah Anda melengkapi semua langkah.
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('search-modal');
        const openButton = document.getElementById('open-search-modal');
        const closeButtons = [
            document.getElementById('close-search-modal'),
        ];
        const stepPanels = Array.from(document.querySelectorAll('.step-panel'));
        const stepLabel = document.getElementById('step-label');
        const currentStepNumber = document.getElementById('current-step-number');
        const prevButton = document.getElementById('prev-step');
        const nextButton = document.getElementById('next-step');
        const skillItems = Array.from(document.querySelectorAll('.skill-item'));
        const specializationItems = Array.from(document.querySelectorAll('.specialization-item'));
        const form = document.getElementById('wizard-form');
        const skillInputs = document.getElementById('skill-inputs');
        const specializationInputs = document.getElementById('specialization-inputs');

        let currentStep = 1;
        const maxStep = 4;
        const selectedSkills = new Set(@json(array_map('strval', (array) request('skill_ids', []))));
        const selectedSpecializations = new Set(@json(array_map('strval', (array) request('specialization_ids', []))));
        console.log('skillItems count:', skillItems.length, 'specializationItems count:', specializationItems.length);
        console.log('selectedSkills:', Array.from(selectedSkills), 'selectedSpecializations:', Array.from(selectedSpecializations));

        function updateStep() {
            stepPanels.forEach((panel, index) => {
                panel.classList.toggle('hidden', index !== currentStep - 1);
            });
            currentStepNumber.textContent = currentStep;
            stepLabel.textContent = `Step ${currentStep}`;
            prevButton.disabled = currentStep === 1;
            nextButton.textContent = currentStep === maxStep ? 'Cari Sekarang' : 'Next';
        }

        function toggleSelection(item, selectedSet) {
            const value = item.dataset.value;
            if (selectedSet.has(value)) {
                selectedSet.delete(value);
                item.classList.remove('border-indigo-500', 'bg-indigo-50', 'text-indigo-900', 'dark:border-indigo-500', 'dark:bg-indigo-950');
                item.classList.remove('selected');
            } else {
                selectedSet.add(value);
                item.classList.add('border-indigo-500', 'bg-indigo-50', 'text-indigo-900', 'dark:border-indigo-500', 'dark:bg-indigo-950');
                item.classList.add('selected');
            }
            updateHiddenInputs();
        }

        function restoreSelections(items, selectedSet) {
            items.forEach((item) => {
                if (selectedSet.has(item.dataset.value)) {
                    item.classList.add('border-indigo-500', 'bg-indigo-50', 'text-indigo-900', 'dark:border-indigo-500', 'dark:bg-indigo-950');
                    item.classList.add('selected');
                }
            });
        }

        function updateHiddenInputs() {
            skillInputs.innerHTML = '';
            specializationInputs.innerHTML = '';

            selectedSkills.forEach((value) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'skill_ids[]';
                input.value = value;
                skillInputs.appendChild(input);
            });

            selectedSpecializations.forEach((value) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'specialization_ids[]';
                input.value = value;
                specializationInputs.appendChild(input);
            });
        }

        skillItems.forEach((item) => {
            item.addEventListener('click', () => toggleSelection(item, selectedSkills));
        });

        specializationItems.forEach((item) => {
            item.addEventListener('click', () => toggleSelection(item, selectedSpecializations));
        });

        restoreSelections(skillItems, selectedSkills);
        restoreSelections(specializationItems, selectedSpecializations);
        updateHiddenInputs();

        prevButton.addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep -= 1;
                updateStep();
            }
        });

        nextButton.addEventListener('click', () => {
            if (currentStep < maxStep) {
                currentStep += 1;
                updateStep();
            } else {
                updateHiddenInputs();
                form.submit();
            }
        });

        form.addEventListener('submit', () => {
            updateHiddenInputs();
        });

        openButton.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            updateStep();
        });

        closeButtons.forEach((button) => {
            button.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
        });

        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });

        const shouldOpenModal = @json(array_filter($criteria) ? true : false);
        if (shouldOpenModal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            currentStep = maxStep;
            updateStep();
        }
    </script>
</x-app-layout>
