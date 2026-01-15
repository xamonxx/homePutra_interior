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

<script>
    // Calculator State
    const calcState = {
        currentStep: 1,
        totalSteps: 3,
        location: 'dalam_kota',
        product: null,
        material: null,
        model: null,
        length: 3,
        includeShipping: true,
        additionalCosts: [],
        data: {
            products: [],
            materials: [],
            models: [],
            additionalCosts: []
        },
        result: null
    };

    // Format currency
    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(amount);
    }

    // Initialize Calculator
    async function initCalculator() {
        try {
            const response = await fetch('<?= SITE_URL ?>/api/calculator.php?action=init');
            const result = await response.json();
            if (result.success) {
                calcState.data = result.data;
                renderProducts();
                renderModels();
                renderAdditionalCosts();
            }
        } catch (error) {
            console.error('Failed to initialize calculator:', error);
        }
    }

    // Render Products
    function renderProducts() {
        const grid = document.getElementById('product-grid');
        const icons = {
            'kitchen-set': 'countertops',
            'wardrobe': 'door_sliding',
            'backdrop-tv': 'tv',
            'wallpanel': 'dashboard'
        };
        grid.innerHTML = calcState.data.products.map((p, i) => `
        <label class="product-option cursor-pointer group">
            <input type="radio" name="product" value="${p.id}" data-slug="${p.slug}" class="hidden" ${i === 0 ? 'checked' : ''}>
            <div class="border-2 ${i === 0 ? 'border-primary bg-primary/10' : 'border-white/10 bg-white/[0.02]'} rounded-xl p-5 text-center transition-all group-hover:border-primary/50 h-full">
                <span class="material-symbols-outlined text-3xl ${i === 0 ? 'text-primary' : 'text-gray-400'} mb-2 block">${icons[p.slug] || p.icon}</span>
                <div class="text-white text-sm font-medium">${p.name}</div>
            </div>
        </label>
    `).join('');

        if (calcState.data.products.length > 0) {
            calcState.product = calcState.data.products[0].id;
            updateProductPreview();
        }

        // Add event listeners
        document.querySelectorAll('input[name="product"]').forEach(input => {
            input.addEventListener('change', function() {
                calcState.product = parseInt(this.value);
                document.querySelectorAll('.product-option > div').forEach(d => {
                    d.classList.remove('border-primary', 'bg-primary/10');
                    d.classList.add('border-white/10', 'bg-white/[0.02]');
                    d.querySelector('.material-symbols-outlined').classList.remove('text-primary');
                    d.querySelector('.material-symbols-outlined').classList.add('text-gray-400');
                });
                this.nextElementSibling.classList.add('border-primary', 'bg-primary/10');
                this.nextElementSibling.classList.remove('border-white/10', 'bg-white/[0.02]');
                this.nextElementSibling.querySelector('.material-symbols-outlined').classList.add('text-primary');
                this.nextElementSibling.querySelector('.material-symbols-outlined').classList.remove('text-gray-400');
                updateProductPreview();
                loadMaterialsForProduct(calcState.product);
            });
        });
    }

    // Product images and base prices data
    const productData = {
        1: {
            slug: 'kitchen-set',
            image: '<?= SITE_URL ?>/assets/images/products/kitchen-set.png',
            minPrice: 2000000
        },
        2: {
            slug: 'wardrobe',
            image: '<?= SITE_URL ?>/assets/images/products/wardrobe.png',
            minPrice: 2300000
        },
        3: {
            slug: 'backdrop-tv',
            image: '<?= SITE_URL ?>/assets/images/products/backdrop-tv.png',
            minPrice: 2100000
        },
        4: {
            slug: 'wallpanel',
            image: '<?= SITE_URL ?>/assets/images/products/wallpanel.png',
            minPrice: 850000
        }
    };

    // Update product preview
    function updateProductPreview() {
        const product = productData[calcState.product];
        if (!product) return;

        const previewImage = document.getElementById('preview-image');
        const previewPrice = document.getElementById('preview-price');
        const previewBadge = document.getElementById('preview-badge');

        if (previewImage) previewImage.src = product.image;
        if (previewPrice) previewPrice.textContent = formatCurrency(product.minPrice);

        let badge = 'Best Value';
        let badgeClass = 'bg-primary text-black';
        if (product.minPrice <= 1000000) {
            badge = 'Ekonomis';
            badgeClass = 'bg-green-500 text-white';
        } else if (product.minPrice >= 3500000) {
            badge = 'Premium';
            badgeClass = 'bg-purple-500 text-white';
        }

        if (previewBadge) {
            previewBadge.textContent = badge;
            previewBadge.className = `inline-block px-4 py-2 ${badgeClass} text-xs font-bold uppercase tracking-wider rounded-full shadow-lg`;
        }
    }

    // Load Materials for Product
    async function loadMaterialsForProduct(productId) {
        try {
            const response = await fetch(`<?= SITE_URL ?>/api/calculator.php?action=get_materials&product_id=${productId}`);
            const result = await response.json();
            if (result.success) {
                calcState.data.materials = result.data;
                renderMaterials();
            }
        } catch (error) {
            console.error('Failed to load materials:', error);
        }
    }

    // Render Materials
    function renderMaterials() {
        const grid = document.getElementById('material-grid');
        const gradeColors = {
            'A': 'bg-green-500/20 text-green-400',
            'B': 'bg-blue-500/20 text-blue-400',
            'C': 'bg-yellow-500/20 text-yellow-400'
        };
        grid.innerHTML = calcState.data.materials.map((m, i) => `
        <label class="material-option cursor-pointer group">
            <input type="radio" name="material" value="${m.id}" class="hidden" ${i === 0 ? 'checked' : ''}>
            <div class="border-2 ${i === 0 ? 'border-primary bg-primary/10' : 'border-white/10 bg-white/[0.02]'} rounded-xl p-5 transition-all group-hover:border-primary/50">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-white font-semibold">${m.name}</span>
                    <span class="text-xs ${gradeColors[m.grade]} font-bold px-2 py-1 rounded">Grade ${m.grade}</span>
                </div>
                <div class="flex gap-2 flex-wrap">
                    ${m.is_waterproof == 1 ? '<span class="text-[10px] bg-blue-500/20 text-blue-400 px-2 py-1 rounded-full font-medium">Anti Air</span>' : ''}
                    ${m.is_termite_resistant == 1 ? '<span class="text-[10px] bg-green-500/20 text-green-400 px-2 py-1 rounded-full font-medium">Anti Rayap</span>' : ''}
                </div>
            </div>
        </label>
    `).join('');

        if (calcState.data.materials.length > 0) {
            calcState.material = calcState.data.materials[0].id;
            updateLivePrice();
        }

        document.querySelectorAll('input[name="material"]').forEach(input => {
            input.addEventListener('change', function() {
                calcState.material = parseInt(this.value);
                document.querySelectorAll('.material-option > div').forEach(d => {
                    d.classList.remove('border-primary', 'bg-primary/10');
                    d.classList.add('border-white/10', 'bg-white/[0.02]');
                });
                this.nextElementSibling.classList.add('border-primary', 'bg-primary/10');
                this.nextElementSibling.classList.remove('border-white/10', 'bg-white/[0.02]');
                updateLivePrice();
            });
        });
    }

    // Update live price display
    function updateLivePrice() {
        const livePrice = document.getElementById('live-price');
        const liveLocation = document.getElementById('live-location');
        const priceComparison = document.getElementById('price-comparison');

        if (!livePrice) return;

        fetch(`<?= SITE_URL ?>/api/calculator.php?action=get_price&product_id=${calcState.product}&material_id=${calcState.material}&model_id=${calcState.model}&location_type=${calcState.location}`)
            .then(res => res.json())
            .then(data => {
                if (data.price_per_meter) {
                    livePrice.textContent = formatCurrency(data.price_per_meter);
                }
            });

        liveLocation.textContent = calcState.location === 'dalam_kota' ? 'Dalam Kota' : 'Luar Kota';

        const models = ['Minimalis', 'Semi Klasik', 'Klasik', 'Luxury'];
        let comparisonHtml = '';
        models.forEach((model, idx) => {
            const isActive = calcState.model === (idx + 1);
            comparisonHtml += `
                <div class="flex items-center justify-between py-3 px-3 ${isActive ? 'bg-primary/15 rounded-lg' : ''}">
                    <span class="text-sm ${isActive ? 'text-primary font-bold' : 'text-gray-400'}">${model}</span>
                    <span class="text-sm ${isActive ? 'text-primary font-bold' : 'text-white'}" id="price-model-${idx + 1}">-</span>
                </div>
            `;
        });
        priceComparison.innerHTML = comparisonHtml;

        models.forEach((model, idx) => {
            fetch(`<?= SITE_URL ?>/api/calculator.php?action=get_price&product_id=${calcState.product}&material_id=${calcState.material}&model_id=${idx + 1}&location_type=${calcState.location}`)
                .then(res => res.json())
                .then(data => {
                    const el = document.getElementById(`price-model-${idx + 1}`);
                    if (el && data.price_per_meter) {
                        el.textContent = formatCurrency(data.price_per_meter);
                    }
                });
        });
    }

    // Render Models
    function renderModels() {
        const grid = document.getElementById('model-grid');
        grid.innerHTML = calcState.data.models.map((m, i) => `
        <label class="model-option cursor-pointer group">
            <input type="radio" name="model" value="${m.id}" class="hidden" ${i === 0 ? 'checked' : ''}>
            <div class="border-2 ${i === 0 ? 'border-primary bg-primary/10' : 'border-white/10 bg-white/[0.02]'} rounded-xl py-4 px-3 text-center transition-all group-hover:border-primary/50">
                <span class="text-white text-sm font-medium">${m.name}</span>
            </div>
        </label>
    `).join('');

        if (calcState.data.models.length > 0) {
            calcState.model = calcState.data.models[0].id;
        }

        document.querySelectorAll('input[name="model"]').forEach(input => {
            input.addEventListener('change', function() {
                calcState.model = parseInt(this.value);
                document.querySelectorAll('.model-option > div').forEach(d => {
                    d.classList.remove('border-primary', 'bg-primary/10');
                    d.classList.add('border-white/10', 'bg-white/[0.02]');
                });
                this.nextElementSibling.classList.add('border-primary', 'bg-primary/10');
                this.nextElementSibling.classList.remove('border-white/10', 'bg-white/[0.02]');
                updateLivePrice();
            });
        });
    }

    // Render Additional Costs
    function renderAdditionalCosts() {
        const container = document.getElementById('additional-costs');
        const html = calcState.data.additionalCosts.map(c => `
        <label class="flex items-center gap-4 p-5 bg-white/[0.03] border border-white/10 rounded-xl cursor-pointer hover:border-primary/50 transition-all group">
            <input type="checkbox" name="additional_cost" value="${c.id}" class="w-6 h-6 rounded-lg border-2 border-gray-600 text-primary focus:ring-primary focus:ring-offset-0 bg-transparent">
            <div class="flex-1">
                <span class="text-white font-semibold block">${c.name}</span>
                <span class="text-gray-400 text-sm">${c.description || ''}</span>
            </div>
            <span class="text-primary font-bold">+${c.cost_type === 'percentage' ? c.cost_value + '%' : formatCurrency(c.cost_value)}</span>
        </label>
    `).join('');

        container.innerHTML += html;
    }

    // Location change handler
    document.querySelectorAll('input[name="location"]').forEach(input => {
        input.addEventListener('change', function() {
            calcState.location = this.value;
            document.querySelectorAll('.location-option > div').forEach(d => {
                d.classList.remove('border-primary', 'bg-primary/10');
                d.classList.add('border-white/10');
                const icon = d.querySelector('.material-symbols-outlined');
                icon.classList.remove('text-primary');
                icon.classList.add('text-gray-400');
                const container = d.querySelector('.w-12.h-12');
                if (container) {
                    container.classList.remove('bg-primary/20');
                    container.classList.add('bg-white/5');
                }
            });
            this.nextElementSibling.classList.add('border-primary', 'bg-primary/10');
            this.nextElementSibling.classList.remove('border-white/10');
            const activeIcon = this.nextElementSibling.querySelector('.material-symbols-outlined');
            activeIcon.classList.add('text-primary');
            activeIcon.classList.remove('text-gray-400');
            const activeContainer = this.nextElementSibling.querySelector('.w-12.h-12');
            if (activeContainer) {
                activeContainer.classList.add('bg-primary/20');
                activeContainer.classList.remove('bg-white/5');
            }

            // Toggle location sections based on selection
            const jabarSection = document.getElementById('jabar-location-section');
            const luarJabarSection = document.getElementById('luar-jabar-location-section');

            if (this.value === 'dalam_kota') {
                // Show Jawa Barat dropdown, hide manual input
                jabarSection.classList.remove('hidden');
                luarJabarSection.classList.add('hidden');
            } else {
                // Hide Jawa Barat dropdown, show manual input
                jabarSection.classList.add('hidden');
                luarJabarSection.classList.remove('hidden');
            }

            updateProductPreview();
        });
    });

    // Custom Jabar Dropdown Handler
    const jabarInput = document.getElementById('kota-kabupaten-search');
    const jabarDropdown = document.getElementById('jabar-dropdown');
    const jabarArrow = document.getElementById('jabar-arrow');
    const jabarOptions = document.querySelectorAll('.jabar-option');
    const jabarNoResults = document.getElementById('jabar-no-results');
    const jabarGroups = document.querySelectorAll('.jabar-group');

    // Make input editable and toggle dropdown
    jabarInput.removeAttribute('readonly');

    jabarInput.addEventListener('focus', function() {
        openJabarDropdown();
    });

    jabarInput.addEventListener('click', function(e) {
        e.stopPropagation();
        if (jabarDropdown.classList.contains('hidden')) {
            openJabarDropdown();
        }
    });

    // Filter as user types
    jabarInput.addEventListener('input', function() {
        filterJabarOptions(this.value.toLowerCase());
        if (jabarDropdown.classList.contains('hidden')) {
            openJabarDropdown();
        }
    });

    function openJabarDropdown() {
        jabarDropdown.classList.remove('hidden');
        jabarArrow.querySelector('span').style.transform = 'rotate(180deg)';
        jabarInput.classList.add('border-primary');
    }

    function closeJabarDropdown() {
        jabarDropdown.classList.add('hidden');
        jabarArrow.querySelector('span').style.transform = 'rotate(0deg)';
        jabarInput.classList.remove('border-primary');
    }

    function filterJabarOptions(query) {
        let visibleCount = 0;

        jabarOptions.forEach(option => {
            const text = option.textContent.toLowerCase();
            if (text.includes(query)) {
                option.classList.remove('hidden');
                visibleCount++;
            } else {
                option.classList.add('hidden');
            }
        });

        // Show/hide group headers based on visible options
        jabarGroups.forEach(group => {
            const visibleInGroup = group.querySelectorAll('.jabar-option:not(.hidden)').length;
            if (visibleInGroup === 0) {
                group.classList.add('hidden');
            } else {
                group.classList.remove('hidden');
            }
        });

        // Show no results message
        if (visibleCount === 0) {
            jabarNoResults.classList.remove('hidden');
        } else {
            jabarNoResults.classList.add('hidden');
        }
    }

    // Select option
    jabarOptions.forEach(option => {
        option.addEventListener('click', function() {
            const value = this.dataset.value;
            jabarInput.value = value;
            calcState.kotaKabupaten = value;
            closeJabarDropdown();
            filterJabarOptions(''); // Reset filter
        });
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const container = document.getElementById('jabar-dropdown-container');
        if (container && !container.contains(e.target)) {
            closeJabarDropdown();
        }
    });


    // Length input handlers
    const lengthInput = document.getElementById('length-input');
    const lengthSlider = document.getElementById('length-slider');

    lengthInput.addEventListener('input', function() {
        let val = parseFloat(this.value) || 0;
        if (val > 50) val = 50;
        if (val < 0) val = 0;
        calcState.length = val;
        lengthSlider.value = Math.min(val, 20);
    });

    lengthSlider.addEventListener('input', function() {
        calcState.length = parseFloat(this.value);
        lengthInput.value = this.value;
    });

    function adjustLength(delta) {
        let newVal = calcState.length + delta;
        if (newVal < 0.5) newVal = 0.5;
        if (newVal > 50) newVal = 50;
        calcState.length = newVal;
        lengthInput.value = newVal;
        lengthSlider.value = Math.min(newVal, 20);
    }

    // Step Navigation
    function updateStepIndicators() {
        for (let i = 1; i <= 3; i++) {
            const indicator = document.getElementById(`step${i}-indicator`);
            const progress = document.getElementById(`step${i}-progress`);

            if (i < calcState.currentStep) {
                indicator.classList.remove('bg-white/10', 'text-white/50');
                indicator.classList.add('bg-primary', 'text-black', 'shadow-lg', 'shadow-primary/30');
                indicator.innerHTML = '<span class="material-symbols-outlined text-lg">check</span>';
                if (progress) progress.style.width = '100%';
            } else if (i === calcState.currentStep) {
                indicator.classList.remove('bg-white/10', 'text-white/50');
                indicator.classList.add('bg-primary', 'text-black', 'shadow-lg', 'shadow-primary/30');
                indicator.textContent = i;
                if (progress) progress.style.width = '100%';
            } else {
                indicator.classList.add('bg-white/10', 'text-white/50');
                indicator.classList.remove('bg-primary', 'text-black', 'shadow-lg', 'shadow-primary/30');
                indicator.textContent = i;
                if (progress) progress.style.width = '0%';
            }
        }
    }

    function showStep(step) {
        document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
        document.getElementById(`step${step}`).classList.remove('hidden');

        document.getElementById('btn-prev').classList.toggle('hidden', step === 1);
        document.getElementById('btn-next').classList.toggle('hidden', step === 3);
        document.getElementById('btn-calculate').classList.toggle('hidden', step !== 3);

        updateStepIndicators();
    }

    function nextStep() {
        if (calcState.currentStep < 3) {
            // Validation for Step 1
            if (calcState.currentStep === 1) {
                const name = document.getElementById('customer-name').value.trim();
                let address = '';

                if (calcState.location === 'dalam_kota') {
                    address = document.getElementById('kota-kabupaten-search').value.trim();
                } else {
                    const prov = document.getElementById('provinsi-input').value.trim();
                    const city = document.getElementById('kota-input').value.trim();
                    if (prov && city) address = `${city}, ${prov}`;
                }

                if (!name) {
                    alert('Mohon masukkan Nama Lengkap Anda');
                    document.getElementById('customer-name').focus();
                    return;
                }
                if (!address) {
                    alert('Mohon lengkapi data Lokasi/Alamat Anda');
                    if (calcState.location === 'dalam_kota') {
                        document.getElementById('kota-kabupaten-search').focus();
                    } else {
                        document.getElementById('kota-input').focus();
                    }
                    return;
                }

                loadMaterialsForProduct(calcState.product);
            }
            calcState.currentStep++;
            showStep(calcState.currentStep);
        }
    }

    function prevStep() {
        if (calcState.currentStep > 1) {
            calcState.currentStep--;
            showStep(calcState.currentStep);
        }
    }

    function resetCalculator() {
        calcState.currentStep = 1;
        calcState.location = 'dalam_kota';
        calcState.length = 3;
        calcState.additionalCosts = [];
        calcState.result = null;

        lengthInput.value = 3;
        lengthSlider.value = 3;

        document.querySelectorAll('input[type="checkbox"]').forEach(cb => {
            if (cb.id !== 'include-shipping') cb.checked = false;
        });
        document.getElementById('include-shipping').checked = true;

        document.getElementById('summary-placeholder').classList.remove('hidden');
        document.getElementById('summary-content').classList.add('hidden');

        showStep(1);
    }

    // Calculate Estimate
    async function calculateEstimate() {
        const additionalCostIds = [];
        document.querySelectorAll('input[name="additional_cost"]:checked').forEach(cb => {
            additionalCostIds.push(parseInt(cb.value));
        });
        calcState.additionalCosts = additionalCostIds;
        calcState.includeShipping = document.getElementById('include-shipping').checked;

        // Get alamat based on location type
        let alamat = '';
        if (calcState.location === 'dalam_kota') {
            alamat = document.getElementById('kota-kabupaten-search').value || '';
        } else {
            const provinsi = document.getElementById('provinsi-input').value || '';
            const kota = document.getElementById('kota-input').value || '';
            alamat = [kota, provinsi].filter(Boolean).join(', ');
        }

        try {
            const response = await fetch('<?= SITE_URL ?>/api/calculator.php?action=calculate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    product_id: calcState.product,
                    material_id: calcState.material,
                    model_id: calcState.model,
                    location_type: calcState.location,
                    length: calcState.length,
                    include_shipping: calcState.includeShipping,
                    additional_costs: calcState.additionalCosts,
                    alamat: alamat,
                    nama: document.getElementById('customer-name').value.trim()
                })
            });

            const result = await response.json();

            if (result.success) {
                calcState.result = result.data;
                displayResult(result.data);
            } else {
                alert(result.error || 'Gagal menghitung estimasi');
            }
        } catch (error) {
            console.error('Calculate error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    // Display Result
    function displayResult(data) {
        document.getElementById('summary-placeholder').classList.add('hidden');
        document.getElementById('summary-content').classList.remove('hidden');

        document.getElementById('summary-location').textContent = data.location_label;
        document.getElementById('summary-product').textContent = data.product;
        document.getElementById('summary-material').textContent = data.material;
        document.getElementById('summary-model').textContent = data.model;
        document.getElementById('summary-length').textContent = data.length + ' meter';
        document.getElementById('summary-price-per-meter').textContent = formatCurrency(data.price_per_meter);
        document.getElementById('summary-subtotal').textContent = formatCurrency(data.subtotal);
        document.getElementById('summary-shipping').textContent = data.shipping_label;

        if (data.additional_costs > 0) {
            document.getElementById('summary-additional-row').classList.remove('hidden');
            document.getElementById('summary-additional').textContent = formatCurrency(data.additional_costs);
        } else {
            document.getElementById('summary-additional-row').classList.add('hidden');
        }

        const badgeColors = {
            'Ekonomis': 'bg-green-500/20 text-green-400',
            'Best Value': 'bg-primary/20 text-primary',
            'Premium': 'bg-purple-500/20 text-purple-400'
        };
        document.getElementById('summary-badge').innerHTML = `<span class="inline-block px-5 py-2 ${badgeColors[data.badge] || badgeColors['Best Value']} rounded-full text-sm font-bold uppercase tracking-wider">${data.badge}</span>`;

        document.getElementById('summary-total-range').textContent = formatCurrency(data.min_total) + ' – ' + formatCurrency(data.max_total);
        document.getElementById('summary-text').textContent = data.summary;
    }

    // Send to WhatsApp
    function sendToWhatsApp() {
        if (!calcState.result) {
            alert('Silakan hitung estimasi terlebih dahulu');
            return;
        }
        const d = calcState.result;

        // Build detailed items list for WhatsApp
        let details = `📍 Lokasi: ${d.location_label}\n`;
        details += `📦 Produk: ${d.product}\n`;
        details += `🪵 Material: ${d.material}\n`;
        details += `🎨 Model: ${d.model}\n`;
        details += `📏 Panjang: ${d.length} meter\n\n`;

        details += `💰 Rincian Estimasi:\n`;
        details += `- Harga/m: ${formatCurrency(d.price_per_meter)}\n`;
        details += `- Subtotal: ${formatCurrency(d.subtotal)}\n`;
        details += `- Ongkir: ${d.shipping_label}\n`;

        if (d.additional_costs > 0) {
            details += `- Tambahan: ${formatCurrency(d.additional_costs)}\n`;
        }

        details += `\n✨ ESTIMASI TOTAL:\n${formatCurrency(d.min_total)} – ${formatCurrency(d.max_total)}`;

        const customerName = document.getElementById('customer-name').value || 'Pelanggan';
        const text = encodeURIComponent(`Halo Home Putra Interior! 👋\n\nSaya ${customerName}, saya telah menggunakan Kalkulator Estimasi di website dan tertarik dengan rincian berikut:\n\n${details}\n\nMohon informasi lebih lanjut untuk survey lokasi. Terima kasih! 🙏`);

        window.open(`https://wa.me/6281234567890?text=${text}`, '_blank');
    }

    // Export PDF with Premium Elegant Design
    async function exportPDF() {
        if (!calcState.result) {
            alert('Silakan hitung estimasi terlebih dahulu');
            return;
        }

        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF({
            orientation: 'portrait',
            unit: 'mm',
            format: 'a4'
        });

        const data = calcState.result;
        const goldAccent = [197, 158, 62]; // Sophisticated Gold
        const darkNavy = [15, 23, 42]; // Premium Navy
        const darkGray = [51, 65, 85];
        const lightGray = [248, 250, 252];
        const borderGray = [226, 232, 240];

        // --- 1. PREMIUM HEADER ---
        // Top accent line
        doc.setFillColor(...goldAccent);
        doc.rect(0, 0, 210, 2, 'F');

        // Logo Section
        doc.setFillColor(...darkNavy);
        doc.roundedRect(15, 12, 12, 12, 2, 2, 'F');
        doc.setTextColor(255, 255, 255);
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(10);
        doc.text('H', 19.5, 20);

        // Brand Name
        doc.setTextColor(...darkNavy);
        doc.setFontSize(18);
        doc.setFont('times', 'bold'); // Serif font for premium feel
        doc.text('Home Putra', 32, 19);
        doc.setFont('times', 'italic');
        doc.setTextColor(...goldAccent);
        doc.text('Interior', 68, 19);

        doc.setFont('helvetica', 'normal');
        doc.setFontSize(7.5);
        doc.setTextColor(...darkGray);
        doc.text('PREMIUM INTERIOR DESIGN & FURNITURE STUDIO', 32, 24);

        // Right side info (Invoice / Ref)
        const refNo = 'EST/' + new Date().getFullYear() + '/' + Math.random().toString(36).substr(2, 5).toUpperCase();
        doc.setFontSize(8);
        doc.setTextColor(...darkGray);
        doc.setFont('helvetica', 'bold');
        doc.text('ESTIMASI PENAWARAN', 195, 17, {
            align: 'right'
        });
        doc.setFont('helvetica', 'normal');
        doc.text(`Ref No: ${refNo}`, 195, 21.5, {
            align: 'right'
        });
        doc.text(`Tanggal: ${new Date().toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})}`, 195, 26, {
            align: 'right'
        });

        // Decorative line
        doc.setDrawColor(...borderGray);
        doc.setLineWidth(0.2);
        doc.line(15, 35, 195, 35);

        // --- 2. CUSTOMER & PROJECT INFO ---
        doc.setTextColor(...darkNavy);
        doc.setFontSize(10);
        doc.setFont('helvetica', 'bold');
        doc.text('Informasi Klien', 15, 45);
        doc.text('Spesifikasi Utama', 110, 45);

        // Clientele info box
        doc.setFillColor(...lightGray);
        doc.roundedRect(15, 48, 85, 25, 1, 1, 'F');
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(8.5);
        doc.setTextColor(...darkGray);

        const customerName = document.getElementById('customer-name').value || 'Walk-in Customer';
        doc.text([
            `Nama: ${customerName}`,
            `Lokasi: ${data.location_label}`,
            `Status: Estimasi Awal`
        ], 20, 55);

        // Specs info box
        doc.setFillColor(...lightGray);
        doc.roundedRect(110, 48, 85, 25, 1, 1, 'F');
        doc.text([
            `Produk: ${data.product}`,
            `Material: ${data.material}`,
            `Model: ${data.model}`,
            `Dimensi: ${data.length} Meter Lari`
        ], 115, 53.5);

        // --- 3. PRICING TABLE ---
        doc.setFontSize(10);
        doc.setFont('helvetica', 'bold');
        doc.setTextColor(...darkNavy);
        doc.text('Rincian Pekerjaan', 15, 85);

        const tableBody = [
            ['01', `${data.product} - Custom Furniture\nSpec: ${data.material} • ${data.model}`, `${data.length} m`, formatCurrency(data.price_per_meter), formatCurrency(data.subtotal)]
        ];

        // Add additional costs
        if (data.additional_details && data.additional_details.length > 0) {
            data.additional_details.forEach((item, idx) => {
                tableBody.push(['02.' + (idx + 1), item.name, '1 Lot', '-', formatCurrency(item.amount)]);
            });
        }

        // Add shipping
        tableBody.push(['03', 'Logistic & Installation Fee', '1 Lot', '-', data.shipping_label]);

        doc.autoTable({
            startY: 90,
            head: [
                ['No', 'Uraian Pekerjaan', 'QTY', 'Harga Satuan', 'Total']
            ],
            body: tableBody,
            theme: 'plain',
            headStyles: {
                fillColor: [...darkNavy],
                textColor: [255, 255, 255],
                fontSize: 8.5,
                fontStyle: 'bold',
                halign: 'center'
            },
            bodyStyles: {
                fontSize: 8,
                textColor: [...darkGray],
                cellPadding: 4
            },
            columnStyles: {
                0: {
                    cellWidth: 10,
                    halign: 'center'
                },
                1: {
                    cellWidth: 90
                },
                2: {
                    halign: 'center'
                },
                3: {
                    halign: 'right'
                },
                4: {
                    halign: 'right',
                    fontStyle: 'bold',
                    textColor: [...darkNavy]
                }
            },
            didDrawPage: function(data) {
                // Background for tables
                doc.setDrawColor(...borderGray);
                doc.setLineWidth(0.1);
                doc.line(15, data.cursor.y, 195, data.cursor.y);
            }
        });

        // --- 4. GRAND TOTAL SECTION (PREMIUM CARD) ---
        let currentY = doc.lastAutoTable.finalY + 10;

        // Ensure section doesn't break page
        if (currentY > 230) {
            doc.addPage();
            currentY = 20;
        }

        const totalCardWidth = 85;
        const totalCardX = 110;

        // Card background
        doc.setFillColor(...lightGray);
        doc.rect(totalCardX, currentY, totalCardWidth, 40, 'F');

        // Card edge (decorative)
        doc.setFillColor(...goldAccent);
        doc.rect(totalCardX + totalCardWidth - 2, currentY, 2, 40, 'F');

        doc.setTextColor(...darkGray);
        doc.setFontSize(8);
        doc.setFont('helvetica', 'normal');
        doc.text('Estimasi Minimum:', totalCardX + 5, currentY + 10);
        doc.text('Estimasi Maksimum:', totalCardX + 5, currentY + 16);

        doc.setTextColor(...darkNavy);
        doc.setFont('helvetica', 'bold');
        doc.text(formatCurrency(data.min_total), totalCardX + totalCardWidth - 8, currentY + 10, {
            align: 'right'
        });
        doc.text(formatCurrency(data.max_total), totalCardX + totalCardWidth - 8, currentY + 16, {
            align: 'right'
        });

        doc.setDrawColor(...borderGray);
        doc.line(totalCardX + 5, currentY + 22, totalCardX + totalCardWidth - 8, currentY + 22);

        doc.setFontSize(9);
        doc.setTextColor(...goldAccent);
        doc.text('TOTAL ESTIMASI HUBUNGI ADMIN', totalCardX + 5, currentY + 30);
        doc.setFontSize(11);
        doc.setTextColor(...darkNavy);
        doc.text(`${formatCurrency(data.min_total)} - ${formatCurrency(data.max_total)}`, totalCardX + totalCardWidth - 8, currentY + 36, {
            align: 'right'
        });

        // --- 5. TERMS & SIGNATURE ---
        const footerY = 245;

        doc.setTextColor(...darkNavy);
        doc.setFontSize(9);
        doc.setFont('helvetica', 'bold');
        doc.text('Syarat & Ketentuan:', 15, currentY + 50);

        doc.setFont('helvetica', 'normal');
        doc.setFontSize(7.5);
        doc.setTextColor(...darkGray);
        const terms = [
            '• Harga di atas adalah ESTIMASI AWAL berdasarkan ukuran kasar.',
            '• Harga final ditentukan setelah tim kami melakukan survey lokasi.',
            '• Masa berlaku penawaran ini adalah 14 hari kerja.',
            '• Pembayaran bertahap sesuai progres pengerjaan unit.',
            '• Home Putra Interior menjamin kualitas material sesuai spesifikasi.'
        ];
        doc.text(terms, 15, currentY + 56);

        // Professional Signature Area
        doc.setFontSize(8.5);
        doc.setTextColor(...darkNavy);
        doc.text('Dibuat Oleh,', 150, currentY + 50);
        doc.setFont('times', 'italic');
        doc.text('Sistem Kalkulator Digital', 150, currentY + 65);
        doc.setDrawColor(...borderGray);
        doc.line(150, currentY + 67, 190, currentY + 67);
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(7);
        doc.text('Home Putra Interior Team', 150, currentY + 71);

        // Footer Brand bar
        doc.setFillColor(...darkNavy);
        doc.rect(0, 285, 210, 12, 'F');
        doc.setTextColor(255, 255, 255);
        doc.setFontSize(7);
        doc.text('QUALITY INTERIOR FOR YOUR LIFESTYLE | WWW.HOMEPUTRAINTERIOR.COM', 105, 292.5, {
            align: 'center'
        });

        doc.save(`${refNo.replace(/\//g, '-')}-HomePutra.pdf`);
    }

    // Initialize on load
    document.addEventListener('DOMContentLoaded', initCalculator);
</script>

<!-- PDF Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

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