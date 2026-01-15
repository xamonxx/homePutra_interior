<!-- Budget Calculator Full Section -->
<section class="py-8 sm:py-12 lg:pb-16 bg-[#0a0c10] relative overflow-hidden" id="calculator-form">
    <div class="max-w-[1200px] mx-auto px-4 sm:px-6 relative z-10">
        <!-- Calculator Container -->
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-8">

            <!-- Calculator Form - Left Side -->
            <div class="lg:col-span-3">
                <div class="bg-gradient-to-br from-[#1a1d26] to-[#14171f] border border-white/10 rounded-xl sm:rounded-2xl p-4 sm:p-6 lg:p-8 shadow-2xl relative overflow-hidden">
                    <!-- Glow Effect -->
                    <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-primary/5 blur-[80px] pointer-events-none"></div>

                    <!-- Corner Decoration -->
                    <div class="absolute -top-3 -left-3 w-12 h-12 border-t-2 border-l-2 border-primary/50"></div>
                    <div class="absolute -bottom-3 -right-3 w-12 h-12 border-b-2 border-r-2 border-primary/50"></div>

                    <!-- Step Indicator -->
                    <div class="flex items-center justify-center gap-2 sm:gap-4 mb-6 sm:mb-10 relative z-10">
                        <div class="flex items-center gap-1 sm:gap-2">
                            <div id="step1-indicator" class="w-9 h-9 sm:w-12 sm:h-12 rounded-full bg-primary text-black flex items-center justify-center text-xs sm:text-sm font-bold transition-all shadow-lg shadow-primary/30">1</div>
                            <span class="hidden sm:block text-xs text-white font-medium">Lokasi</span>
                        </div>
                        <div class="h-0.5 w-8 sm:w-16 bg-white/10 rounded-full overflow-hidden">
                            <div id="step1-progress" class="h-full bg-primary transition-all duration-500" style="width: 100%"></div>
                        </div>
                        <div class="flex items-center gap-1 sm:gap-2">
                            <div id="step2-indicator" class="w-9 h-9 sm:w-12 sm:h-12 rounded-full bg-white/10 text-white/50 flex items-center justify-center text-xs sm:text-sm font-bold transition-all">2</div>
                            <span class="hidden sm:block text-xs text-gray-500 font-medium">Material</span>
                        </div>
                        <div class="h-0.5 w-8 sm:w-16 bg-white/10 rounded-full overflow-hidden">
                            <div id="step2-progress" class="h-full bg-primary transition-all duration-500" style="width: 0%"></div>
                        </div>
                        <div class="flex items-center gap-1 sm:gap-2">
                            <div id="step3-indicator" class="w-9 h-9 sm:w-12 sm:h-12 rounded-full bg-white/10 text-white/50 flex items-center justify-center text-xs sm:text-sm font-bold transition-all">3</div>
                            <span class="hidden sm:block text-xs text-gray-500 font-medium">Ukuran</span>
                        </div>
                    </div>

                    <!-- Step 1: Lokasi & Produk -->
                    <div id="step1" class="step-content relative z-10">
                        <h3 class="text-xl text-white font-semibold mb-6 flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-primary/20 flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary">location_on</span>
                            </span>
                            Pilih Lokasi & Produk
                        </h3>

                        <!-- Customer Name -->
                        <div class="mb-8">
                            <label class="block text-xs uppercase tracking-widest font-bold text-gray-300 mb-4">Nama Lengkap</label>
                            <div class="relative">
                                <input type="text" id="customer-name" name="customer_name"
                                    class="w-full bg-[#0a0c10] border-2 border-white/10 rounded-xl text-white p-4 pl-12 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all"
                                    placeholder="Masukkan nama Anda...">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <span class="material-symbols-outlined text-gray-400">person</span>
                                </div>
                            </div>
                        </div>

                        <!-- Location Selection -->
                        <div class="mb-8">
                            <label class="block text-xs uppercase tracking-widest font-bold text-gray-300 mb-4">Jangkauan Lokasi</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <label class="location-option cursor-pointer group">
                                    <input type="radio" name="location" value="dalam_kota" class="hidden" checked>
                                    <div class="border-2 border-primary bg-primary/10 rounded-xl p-5 transition-all group-hover:shadow-lg group-hover:shadow-primary/10">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-xl bg-primary/20 flex items-center justify-center">
                                                <span class="material-symbols-outlined text-primary text-2xl">home_pin</span>
                                            </div>
                                            <div>
                                                <div class="text-white font-semibold">Jawa Barat</div>
                                                <div class="text-gray-400 text-sm">Area Cakupan Utama</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                <label class="location-option cursor-pointer group">
                                    <input type="radio" name="location" value="luar_kota" class="hidden">
                                    <div class="border-2 border-white/10 rounded-xl p-5 transition-all group-hover:border-primary/50 group-hover:bg-white/[0.02]">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center">
                                                <span class="material-symbols-outlined text-gray-400 text-2xl">local_shipping</span>
                                            </div>
                                            <div>
                                                <div class="text-white font-semibold">Luar Jawa Barat</div>
                                                <div class="text-gray-400 text-sm">Nasional & Global</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Kabupaten/Kota Selection - Dalam Jawa Barat (Searchable) -->
                        <div id="jabar-location-section" class="mb-8">
                            <label class="block text-xs uppercase tracking-widest font-bold text-gray-300 mb-4">Kabupaten / Kota di Jawa Barat</label>
                            <div class="relative" id="jabar-dropdown-container">
                                <!-- Searchable Input -->
                                <input type="text" id="kota-kabupaten-search" name="kota_kabupaten_search"
                                    class="w-full bg-[#0a0c10] border-2 border-white/10 rounded-xl text-white p-4 pl-12 pr-12 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all"
                                    placeholder="Ketik untuk mencari kabupaten/kota..." autocomplete="off">

                                <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <span class="material-symbols-outlined text-gray-400">location_on</span>
                                </div>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none" id="jabar-arrow">
                                    <span class="material-symbols-outlined text-gray-500 text-lg transition-transform">expand_more</span>
                                </div>

                                <!-- Custom Dropdown -->
                                <div id="jabar-dropdown" class="absolute left-0 right-0 top-full mt-2 bg-[#1a1d26] border border-white/10 rounded-xl shadow-2xl max-h-72 overflow-y-auto hidden z-50" style="scrollbar-width: thin;">
                                    <!-- Kota Group -->
                                    <div class="jabar-group" data-group="kota">
                                        <div class="px-4 py-2 bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider">🏙️ Kota</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kota Bandung">Kota Bandung</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kota Banjar">Kota Banjar</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kota Bekasi">Kota Bekasi</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kota Bogor">Kota Bogor</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kota Cimahi">Kota Cimahi</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kota Cirebon">Kota Cirebon</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kota Depok">Kota Depok</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kota Sukabumi">Kota Sukabumi</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kota Tasikmalaya">Kota Tasikmalaya</div>
                                    </div>
                                    <!-- Kabupaten Group -->
                                    <div class="jabar-group" data-group="kabupaten">
                                        <div class="px-4 py-2 bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider">🏘️ Kabupaten</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kabupaten Bandung">Kabupaten Bandung</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kabupaten Bandung Barat">Kabupaten Bandung Barat</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kabupaten Bekasi">Kabupaten Bekasi</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kabupaten Bogor">Kabupaten Bogor</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kabupaten Ciamis">Kabupaten Ciamis</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kabupaten Cianjur">Kabupaten Cianjur</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kabupaten Cirebon">Kabupaten Cirebon</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kabupaten Garut">Kabupaten Garut</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kabupaten Indramayu">Kabupaten Indramayu</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kabupaten Karawang">Kabupaten Karawang</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kabupaten Kuningan">Kabupaten Kuningan</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kabupaten Majalengka">Kabupaten Majalengka</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kabupaten Pangandaran">Kabupaten Pangandaran</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kabupaten Purwakarta">Kabupaten Purwakarta</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kabupaten Subang">Kabupaten Subang</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kabupaten Sukabumi">Kabupaten Sukabumi</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kabupaten Sumedang">Kabupaten Sumedang</div>
                                        <div class="jabar-option px-4 py-3 text-white hover:bg-primary/20 cursor-pointer transition-colors" data-value="Kabupaten Tasikmalaya">Kabupaten Tasikmalaya</div>
                                    </div>
                                    <!-- No Results -->
                                    <div id="jabar-no-results" class="px-4 py-6 text-gray-500 text-center hidden">
                                        <span class="material-symbols-outlined text-3xl mb-2 block">search_off</span>
                                        Tidak ditemukan
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-500 text-xs mt-2 flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">info</span>
                                Ketik nama kota/kabupaten atau pilih dari daftar
                            </p>
                        </div>

                        <!-- Manual Location Input - Luar Jawa Barat -->
                        <div id="luar-jabar-location-section" class="mb-8 hidden">
                            <label class="block text-xs uppercase tracking-widest font-bold text-gray-300 mb-4">Lokasi Proyek</label>

                            <!-- Provinsi -->
                            <div class="mb-4">
                                <label class="block text-gray-400 text-xs mb-2">Provinsi</label>
                                <div class="relative">
                                    <input type="text" id="provinsi-input" name="provinsi"
                                        class="w-full bg-[#0a0c10] border-2 border-white/10 rounded-xl text-white p-4 pl-12 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all"
                                        placeholder="Contoh: Jawa Tengah, DKI Jakarta...">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                        <span class="material-symbols-outlined text-gray-400">map</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Kota/Kabupaten -->
                            <div class="mb-4">
                                <label class="block text-gray-400 text-xs mb-2">Kota / Kabupaten</label>
                                <div class="relative">
                                    <input type="text" id="kota-input" name="kota"
                                        class="w-full bg-[#0a0c10] border-2 border-white/10 rounded-xl text-white p-4 pl-12 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all"
                                        placeholder="Contoh: Kota Semarang, Kabupaten Klaten...">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                        <span class="material-symbols-outlined text-gray-400">location_city</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-xl p-4 flex items-start gap-3">
                                <span class="material-symbols-outlined text-yellow-400 text-xl mt-0.5">info</span>
                                <div>
                                    <p class="text-yellow-400 text-sm font-medium mb-1">Biaya Pengiriman Tambahan</p>
                                    <p class="text-gray-400 text-xs">Lokasi di luar Jawa Barat akan dikenakan biaya pengiriman tambahan. Tim kami akan menghubungi untuk konfirmasi ongkir.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Product Selection -->
                        <div class="mb-6">
                            <label class="block text-xs uppercase tracking-widest font-bold text-gray-300 mb-4">Jenis Produk</label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4" id="product-grid">
                                <!-- Products will be loaded dynamically -->
                            </div>
                        </div>

                        <!-- Product Preview Card -->
                        <div id="product-preview" class="mt-8 bg-gradient-to-br from-white/[0.08] to-white/[0.02] border border-white/10 rounded-2xl overflow-hidden">
                            <div class="grid sm:grid-cols-2 gap-0">
                                <!-- Product Image -->
                                <div class="relative aspect-[4/3] sm:aspect-auto overflow-hidden">
                                    <img id="preview-image" src="<?= SITE_URL ?>/assets/images/products/kitchen-set.png" alt="Product Preview" class="w-full h-full object-cover transition-all duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                                    <div class="absolute bottom-4 left-4 right-4">
                                        <span id="preview-badge" class="inline-block px-4 py-2 bg-primary text-black text-xs font-bold uppercase tracking-wider rounded-full shadow-lg">Best Value</span>
                                    </div>
                                </div>
                                <!-- Product Info -->
                                <div class="p-6 flex flex-col justify-center bg-[#14171f]">
                                    <div class="text-xs uppercase tracking-widest text-primary font-bold mb-2">Harga Mulai Dari</div>
                                    <div id="preview-price" class="text-3xl sm:text-4xl font-serif text-white mb-2">Rp 2.000.000</div>
                                    <div class="text-sm text-gray-400 mb-6">per meter lari</div>

                                    <div class="space-y-3">
                                        <div class="flex items-center gap-3 text-gray-300">
                                            <span class="material-symbols-outlined text-green-400 text-lg">check_circle</span>
                                            <span class="text-sm" id="preview-grade">Grade B - Kualitas Standar</span>
                                        </div>
                                        <div class="flex items-center gap-3 text-gray-300">
                                            <span class="material-symbols-outlined text-green-400 text-lg">check_circle</span>
                                            <span class="text-sm">Garansi 2 Tahun</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Material & Model -->
                    <div id="step2" class="step-content hidden relative z-10">
                        <h3 class="text-xl text-white font-semibold mb-6 flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-primary/20 flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary">category</span>
                            </span>
                            Pilih Material & Model
                        </h3>

                        <!-- Material Selection -->
                        <div class="mb-8">
                            <label class="block text-xs uppercase tracking-widest font-bold text-gray-300 mb-4">Material</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" id="material-grid">
                                <!-- Materials will be loaded dynamically -->
                            </div>
                        </div>

                        <!-- Model Selection -->
                        <div class="mb-6">
                            <label class="block text-xs uppercase tracking-widest font-bold text-gray-300 mb-4">Model / Style</label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4" id="model-grid">
                                <!-- Models will be loaded dynamically -->
                            </div>
                        </div>

                        <!-- Live Price Preview -->
                        <div id="price-preview" class="mt-8 bg-gradient-to-br from-primary/20 via-primary/10 to-transparent border border-primary/30 rounded-2xl p-6 relative overflow-hidden">
                            <!-- Decorative glow -->
                            <div class="absolute -top-8 -left-8 w-24 h-24 bg-primary/20 rounded-full blur-2xl"></div>

                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4 relative z-10">
                                <div>
                                    <div class="text-primary/80 text-[10px] uppercase tracking-[0.15em] sm:tracking-[0.2em] font-bold mb-2 sm:mb-3 flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm">payments</span>
                                        Harga Per Meter
                                    </div>
                                    <div id="live-price" class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-white via-primary to-white tracking-tight">Rp 0</div>
                                </div>
                                <div class="sm:text-right">
                                    <div class="text-gray-500 text-[10px] uppercase tracking-[0.15em] sm:tracking-[0.2em] font-bold mb-2 sm:mb-3 flex items-center sm:justify-end gap-2">
                                        <span class="material-symbols-outlined text-sm">location_on</span>
                                        Lokasi
                                    </div>
                                    <div id="live-location" class="text-sm sm:text-base lg:text-lg text-white font-semibold">Jawa Barat</div>
                                </div>
                            </div>

                            <!-- Price Comparison Table -->
                            <div class="bg-black/30 rounded-lg sm:rounded-xl p-3 sm:p-5 mt-4 relative z-10 border border-white/5">
                                <div class="text-[9px] sm:text-[10px] uppercase tracking-[0.15em] sm:tracking-[0.2em] text-gray-400 mb-3 sm:mb-4 font-bold flex items-center gap-2">
                                    <span class="material-symbols-outlined text-xs sm:text-sm text-primary">compare_arrows</span>
                                    Perbandingan Harga Model
                                </div>
                                <div class="space-y-1 sm:space-y-2" id="price-comparison">
                                    <!-- Will be populated by JS -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Dimensions & Extras -->
                    <div id="step3" class="step-content hidden relative z-10">
                        <h3 class="text-xl text-white font-semibold mb-6 flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-primary/20 flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary">straighten</span>
                            </span>
                            Ukuran & Biaya Tambahan
                        </h3>

                        <!-- Length Input -->
                        <div class="mb-8">
                            <label class="block text-xs uppercase tracking-widest font-bold text-gray-300 mb-4">Panjang (Meter Lari)</label>
                            <div class="relative">
                                <input type="number" id="length-input" min="0.5" max="50" step="0.5" value="3"
                                    class="w-full bg-[#0a0c10] border-2 border-white/10 rounded-xl text-white text-3xl font-bold p-5 pr-20 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all"
                                    placeholder="3.0">
                                <span class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 font-medium text-lg">meter</span>
                            </div>
                            <div class="flex items-center gap-3 mt-4">
                                <button type="button" onclick="adjustLength(-0.5)" class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 text-white text-xl font-bold hover:bg-primary hover:text-black hover:border-primary transition-all">−</button>
                                <input type="range" id="length-slider" min="0.5" max="20" step="0.5" value="3"
                                    class="flex-1 h-3 bg-gray-700 rounded-full appearance-none cursor-pointer accent-primary">
                                <button type="button" onclick="adjustLength(0.5)" class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 text-white text-xl font-bold hover:bg-primary hover:text-black hover:border-primary transition-all">+</button>
                            </div>
                        </div>

                        <!-- Additional Costs -->
                        <div class="mb-6">
                            <label class="block text-xs uppercase tracking-widest font-bold text-gray-300 mb-4">Biaya Tambahan (Opsional)</label>
                            <div class="space-y-3" id="additional-costs">
                                <!-- Include Shipping -->
                                <label class="flex items-center gap-4 p-5 bg-white/[0.03] border border-white/10 rounded-xl cursor-pointer hover:border-primary/50 transition-all group">
                                    <input type="checkbox" id="include-shipping" checked class="w-6 h-6 rounded-lg border-2 border-gray-600 text-primary focus:ring-primary focus:ring-offset-0 bg-transparent">
                                    <div class="flex-1">
                                        <span class="text-white font-semibold block">Termasuk Ongkir</span>
                                        <span class="text-gray-400 text-sm">Otomatis dihitung berdasarkan total</span>
                                    </div>
                                    <span class="material-symbols-outlined text-primary text-2xl group-hover:scale-110 transition-transform">local_shipping</span>
                                </label>
                                <!-- More costs loaded dynamically -->
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex flex-wrap items-center justify-between mt-6 sm:mt-10 pt-4 sm:pt-6 border-t border-white/10 relative z-10 gap-3 sm:gap-4">
                        <button type="button" id="btn-prev" onclick="prevStep()" class="hidden px-4 sm:px-6 py-3 sm:py-4 bg-white/5 border border-white/10 rounded-lg sm:rounded-xl text-white text-xs sm:text-sm font-semibold hover:bg-white/10 transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-base sm:text-lg">arrow_back</span>
                            <span class="hidden sm:inline">Kembali</span>
                        </button>
                        <button type="button" id="btn-reset" onclick="resetCalculator()" class="px-4 sm:px-6 py-3 sm:py-4 bg-white/5 border border-white/10 rounded-lg sm:rounded-xl text-white text-xs sm:text-sm font-semibold hover:bg-white/10 transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-base sm:text-lg">refresh</span>
                            <span class="hidden sm:inline">Reset</span>
                        </button>
                        <button type="button" id="btn-next" onclick="nextStep()" class="px-5 sm:px-8 py-3 sm:py-4 bg-primary text-black rounded-lg sm:rounded-xl text-xs sm:text-sm font-bold hover:bg-primary-hover transition-all shadow-lg shadow-primary/30 ml-auto flex items-center gap-2">
                            Lanjut
                            <span class="material-symbols-outlined text-base sm:text-lg">arrow_forward</span>
                        </button>
                        <button type="button" id="btn-calculate" onclick="calculateEstimate()" class="hidden px-5 sm:px-8 py-3 sm:py-4 bg-primary text-black rounded-lg sm:rounded-xl text-xs sm:text-sm font-bold hover:bg-primary-hover transition-all shadow-lg shadow-primary/30 ml-auto flex items-center gap-2">
                            <span class="material-symbols-outlined text-base sm:text-lg">calculate</span>
                            <span class="hidden xs:inline">Hitung</span> Estimasi
                        </button>
                    </div>
                </div>
            </div>

            <!-- Result Panel - Right Side -->
            <div class="lg:col-span-2">
                <div class="bg-gradient-to-br from-[#1a1d26] to-[#14171f] border border-white/10 rounded-xl sm:rounded-2xl p-4 sm:p-6 lg:p-8 shadow-2xl lg:sticky lg:top-24 overflow-hidden">
                    <!-- Glow -->
                    <div class="absolute bottom-0 right-0 w-1/2 h-1/2 bg-primary/5 blur-[60px] pointer-events-none"></div>

                    <h3 class="text-xl text-white font-semibold mb-6 flex items-center gap-3 relative z-10">
                        <span class="w-10 h-10 rounded-xl bg-primary/20 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">receipt_long</span>
                        </span>
                        Ringkasan Estimasi
                    </h3>

                    <!-- Summary Placeholder -->
                    <div id="summary-placeholder" class="text-center py-12 relative z-10">
                        <div class="w-20 h-20 mx-auto bg-white/5 rounded-2xl flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-5xl text-white/20">calculate</span>
                        </div>
                        <p class="text-gray-400 text-sm">Lengkapi form untuk melihat<br>estimasi biaya proyek Anda</p>
                    </div>

                    <div id="summary-content" class="hidden relative z-10">
                        <!-- Location & Product -->
                        <div class="space-y-4 mb-6 pb-6 border-b border-white/10">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-sm">Lokasi</span>
                                <span id="summary-location" class="text-white font-medium">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-sm">Produk</span>
                                <span id="summary-product" class="text-white font-medium">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-sm">Material</span>
                                <span id="summary-material" class="text-white font-medium">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-sm">Model</span>
                                <span id="summary-model" class="text-white font-medium">-</span>
                            </div>
                        </div>

                        <!-- Pricing Details -->
                        <div class="space-y-4 mb-6 pb-6 border-b border-white/10">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-sm">Panjang</span>
                                <span id="summary-length" class="text-white font-bold text-lg">- meter</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-sm">Harga/meter</span>
                                <span id="summary-price-per-meter" class="text-white font-medium">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-sm">Subtotal</span>
                                <span id="summary-subtotal" class="text-white font-medium">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-sm">Ongkos Kirim</span>
                                <span id="summary-shipping" class="text-white font-medium">-</span>
                            </div>
                            <div id="summary-additional-row" class="hidden flex justify-between items-center">
                                <span class="text-gray-400 text-xs sm:text-sm">Biaya Tambahan</span>
                                <span id="summary-additional" class="text-white font-medium text-sm sm:text-base">-</span>
                            </div>
                        </div>

                        <!-- Badge -->
                        <div id="summary-badge" class="mb-4 sm:mb-6 text-center">
                            <span class="inline-block px-4 sm:px-5 py-1.5 sm:py-2 bg-primary/20 text-primary rounded-full text-xs sm:text-sm font-bold uppercase tracking-wider">
                                Best Value
                            </span>
                        </div>

                        <!-- Grand Total -->
                        <div class="bg-gradient-to-br from-primary/30 via-primary/15 to-transparent rounded-xl sm:rounded-2xl p-4 sm:p-6 mb-4 sm:mb-6 border border-primary/20 relative overflow-hidden">
                            <!-- Decorative glow -->
                            <div class="absolute -top-10 -right-10 w-24 sm:w-32 h-24 sm:h-32 bg-primary/20 rounded-full blur-3xl"></div>

                            <div class="text-center relative z-10">
                                <span class="text-primary/80 text-[9px] sm:text-[10px] uppercase tracking-[0.2em] sm:tracking-[0.25em] font-bold block mb-3 sm:mb-4">💰 Estimasi Total</span>
                                <div class="mb-2">
                                    <span id="summary-total-range" class="text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-white via-primary to-white tracking-tight leading-tight">Rp 0</span>
                                </div>
                                <div class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1.5 sm:py-2 bg-white/5 rounded-full mt-2 sm:mt-3">
                                    <span class="material-symbols-outlined text-yellow-400 text-xs sm:text-sm">info</span>
                                    <span class="text-gray-400 text-[10px] sm:text-xs">Estimasi ±10%, bukan harga final</span>
                                </div>
                            </div>
                        </div>

                        <!-- Summary Text -->
                        <div class="bg-white/[0.03] rounded-lg sm:rounded-xl p-3 sm:p-5 mb-4 sm:mb-6 border border-white/5">
                            <p id="summary-text" class="text-gray-300 text-xs sm:text-sm leading-relaxed">-</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-2 sm:space-y-3">
                            <button onclick="sendToWhatsApp()" class="w-full py-3 sm:py-4 bg-[#25D366] text-white rounded-lg sm:rounded-xl text-xs sm:text-sm font-bold hover:bg-[#20BD5A] transition-all flex items-center justify-center gap-2 sm:gap-3 shadow-lg">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                                Kirim via WhatsApp
                            </button>
                            <button onclick="exportPDF()" class="w-full py-3 sm:py-4 bg-white/10 border border-white/10 text-white rounded-lg sm:rounded-xl text-xs sm:text-sm font-bold hover:bg-white/20 transition-all flex items-center justify-center gap-2 sm:gap-3">
                                <span class="material-symbols-outlined text-lg sm:text-xl">picture_as_pdf</span>
                                Download PDF
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Logic Kalkulator -->
<script>
    // Inisialisasi variabel global untuk digunakan di file JS eksternal
    const HP_SITE_URL = '<?= SITE_URL ?>';
</script>

<!-- PDF Libraries (Lokal) -->
<script src="<?= SITE_URL ?>/assets/js/jspdf.umd.min.js"></script>
<script src="<?= SITE_URL ?>/assets/js/jspdf.plugin.autotable.min.js"></script>

<!-- Main Calculator Logic (Lokal) -->
<script src="<?= SITE_URL ?>/assets/js/calculator.js"></script>

<style>
    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ffb204, #e6a003);
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(255, 178, 4, 0.4);
    }

    input[type="range"]::-moz-range-thumb {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ffb204, #e6a003);
        cursor: pointer;
        border: none;
        box-shadow: 0 4px 12px rgba(255, 178, 4, 0.4);
    }

    input[type="checkbox"]:checked {
        background-color: #ffb204;
        border-color: #ffb204;
    }
</style>