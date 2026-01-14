<!-- Calculator Section -->
<section class="py-32 bg-background-dark relative overflow-hidden" id="calculator">
    <!-- Background Gradient -->
    <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-primary/5 to-transparent pointer-events-none"></div>

    <div class="max-w-[1100px] mx-auto px-6 relative z-10">
        <div class="grid md:grid-cols-2 gap-20 items-center">
            <!-- Left Content -->
            <div data-aos="fade-right">
                <span class="text-primary uppercase tracking-[0.4em] text-[10px] font-bold">Perencana Anggaran</span>
                <h2 class="text-4xl md:text-6xl text-white mt-5 mb-8 font-serif">Estimasi Proyek Impian Anda</h2>
                <p class="text-gray-400 mb-10 font-light leading-relaxed">
                    Dapatkan perkiraan cepat untuk proyek renovasi atau desain Anda. Sesuaikan slider untuk menyesuaikan kebutuhan ruang Anda.
                </p>
                <ul class="space-y-6">
                    <li class="flex items-center gap-4 text-gray-300 font-light text-sm">
                        <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                        <span>Model harga transparan</span>
                    </li>
                    <li class="flex items-center gap-4 text-gray-300 font-light text-sm">
                        <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                        <span>Rincian material detail</span>
                    </li>
                    <li class="flex items-center gap-4 text-gray-300 font-light text-sm">
                        <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                        <span>Tanpa biaya konsultasi tersembunyi</span>
                    </li>
                </ul>
            </div>

            <!-- Calculator Card -->
            <div class="bg-surface-dark border border-white/10 rounded-sm p-10 shadow-2xl relative" data-aos="fade-left">
                <!-- Corner Decoration -->
                <div class="absolute -top-4 -left-4 w-12 h-12 border-t-2 border-l-2 border-primary/40"></div>

                <div class="space-y-8">
                    <!-- Room Type Select -->
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-3">Tipe Ruangan</label>
                        <select id="room-type" class="w-full bg-[#1A1A1A] border border-white/10 rounded-sm text-white p-4 focus:ring-1 focus:ring-primary focus:border-primary text-sm font-medium outline-none transition-all">
                            <option value="living">Ruang Tamu</option>
                            <option value="kitchen">Dapur</option>
                            <option value="bedroom">Kamar Tidur Utama</option>
                            <option value="bathroom">Kamar Mandi</option>
                            <option value="fullhouse">Seluruh Rumah</option>
                        </select>
                    </div>

                    <!-- Area Size Slider -->
                    <div>
                        <div class="flex justify-between mb-3">
                            <label class="text-[10px] uppercase tracking-widest font-bold text-gray-400">Luas Area (m²)</label>
                            <span id="area-value" class="text-primary font-bold text-sm">50</span>
                        </div>
                        <input id="area-slider" class="w-full h-2 bg-gray-700 rounded-full appearance-none cursor-pointer accent-primary" max="500" min="10" type="range" value="50" />
                    </div>

                    <!-- Finish Level -->
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-3">Tingkat Finishing</label>
                        <div class="grid grid-cols-3 gap-3">
                            <button id="finish-standard" class="finish-btn border border-white/10 rounded-sm py-3 text-[10px] uppercase tracking-widest text-gray-400 hover:border-primary hover:text-primary transition-colors font-bold" data-multiplier="1">Standar</button>
                            <button id="finish-premium" class="finish-btn active border border-primary bg-primary/10 rounded-sm py-3 text-[10px] uppercase tracking-widest text-primary font-bold" data-multiplier="1.5">Premium</button>
                            <button id="finish-luxury" class="finish-btn border border-white/10 rounded-sm py-3 text-[10px] uppercase tracking-widest text-gray-400 hover:border-primary hover:text-primary transition-colors font-bold" data-multiplier="2.2">Mewah</button>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="h-px bg-white/5 my-6"></div>

                    <!-- Price Result -->
                    <div class="flex justify-between items-end">
                        <span class="text-gray-500 text-[10px] uppercase tracking-widest font-bold">Estimasi Harga</span>
                        <div class="text-right">
                            <span id="price-range" class="block text-3xl md:text-4xl font-serif text-white font-medium">Rp 75jt - 100jt</span>
                            <span class="text-[10px] text-gray-600 italic">*Hanya perkiraan. Belum termasuk pajak.</span>
                        </div>
                    </div>

                    <!-- CTA Button -->
                    <button class="w-full py-5 bg-primary text-black rounded-sm text-[10px] uppercase tracking-[0.2em] font-bold hover:bg-primary-hover transition-all shadow-lg shadow-primary/20 magnetic-btn">
                        Dapatkan Penawaran Detail
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const areaSlider = document.getElementById('area-slider');
        const areaValue = document.getElementById('area-value');
        const priceRange = document.getElementById('price-range');
        const roomType = document.getElementById('room-type');
        const finishBtns = document.querySelectorAll('.finish-btn');

        let selectedMultiplier = 1.5;

        // Room type base prices (per m²) in millions
        const roomPrices = {
            living: 1.5,
            kitchen: 2.5,
            bedroom: 1.3,
            bathroom: 3.0,
            fullhouse: 1.8
        };

        function calculatePrice() {
            const area = parseInt(areaSlider.value);
            const basePrice = roomPrices[roomType.value];
            const minPrice = Math.round(area * basePrice * selectedMultiplier * 0.8);
            const maxPrice = Math.round(area * basePrice * selectedMultiplier * 1.2);

            areaValue.textContent = area;

            if (minPrice >= 1000) {
                priceRange.textContent = `Rp ${(minPrice/1000).toFixed(1)}M - ${(maxPrice/1000).toFixed(1)}M`;
            } else {
                priceRange.textContent = `Rp ${minPrice}jt - ${maxPrice}jt`;
            }
        }

        areaSlider.addEventListener('input', calculatePrice);
        roomType.addEventListener('change', calculatePrice);

        finishBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                finishBtns.forEach(b => {
                    b.classList.remove('active', 'border-primary', 'bg-primary/10', 'text-primary');
                    b.classList.add('border-white/10', 'text-gray-400');
                });
                this.classList.add('active', 'border-primary', 'bg-primary/10', 'text-primary');
                this.classList.remove('border-white/10', 'text-gray-400');
                selectedMultiplier = parseFloat(this.dataset.multiplier);
                calculatePrice();
            });
        });

        calculatePrice();
    });
</script>