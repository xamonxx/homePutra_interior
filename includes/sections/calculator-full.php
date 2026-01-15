<!-- Budget Calculator Full Section -->
<section class="pb-16 bg-[#0a0c10] relative overflow-hidden" id="calculator-form">
    <div class="max-w-[1200px] mx-auto px-6 relative z-10">
        <!-- Calculator Container -->
        <div class="grid lg:grid-cols-5 gap-8">

            <!-- Calculator Form - Left Side -->
            <div class="lg:col-span-3">
                <div class="bg-gradient-to-br from-[#1a1d26] to-[#14171f] border border-white/10 rounded-2xl p-6 sm:p-8 shadow-2xl relative overflow-hidden">
                    <!-- Glow Effect -->
                    <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-primary/5 blur-[80px] pointer-events-none"></div>

                    <!-- Corner Decoration -->
                    <div class="absolute -top-3 -left-3 w-12 h-12 border-t-2 border-l-2 border-primary/50"></div>
                    <div class="absolute -bottom-3 -right-3 w-12 h-12 border-b-2 border-r-2 border-primary/50"></div>

                    <!-- Step Indicator -->
                    <div class="flex items-center justify-center gap-4 mb-10 relative z-10">
                        <div class="flex items-center gap-2">
                            <div id="step1-indicator" class="w-12 h-12 rounded-full bg-primary text-black flex items-center justify-center text-sm font-bold transition-all shadow-lg shadow-primary/30">1</div>
                            <span class="hidden sm:block text-xs text-white font-medium">Lokasi</span>
                        </div>
                        <div class="h-0.5 w-16 bg-white/10 rounded-full overflow-hidden">
                            <div id="step1-progress" class="h-full bg-primary transition-all duration-500" style="width: 100%"></div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div id="step2-indicator" class="w-12 h-12 rounded-full bg-white/10 text-white/50 flex items-center justify-center text-sm font-bold transition-all">2</div>
                            <span class="hidden sm:block text-xs text-gray-500 font-medium">Material</span>
                        </div>
                        <div class="h-0.5 w-16 bg-white/10 rounded-full overflow-hidden">
                            <div id="step2-progress" class="h-full bg-primary transition-all duration-500" style="width: 0%"></div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div id="step3-indicator" class="w-12 h-12 rounded-full bg-white/10 text-white/50 flex items-center justify-center text-sm font-bold transition-all">3</div>
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

                        <!-- Location Selection -->
                        <div class="mb-8">
                            <label class="block text-xs uppercase tracking-widest font-bold text-gray-300 mb-4">Lokasi Proyek</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <label class="location-option cursor-pointer group">
                                    <input type="radio" name="location" value="dalam_kota" class="hidden" checked>
                                    <div class="border-2 border-primary bg-primary/10 rounded-xl p-5 transition-all group-hover:shadow-lg group-hover:shadow-primary/10">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-xl bg-primary/20 flex items-center justify-center">
                                                <span class="material-symbols-outlined text-primary text-2xl">home_pin</span>
                                            </div>
                                            <div>
                                                <div class="text-white font-semibold">Dalam Kota</div>
                                                <div class="text-gray-400 text-sm">Jawa Timur</div>
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
                                                <div class="text-white font-semibold">Luar Kota</div>
                                                <div class="text-gray-400 text-sm">Jabodetabek, Pantura, Jateng</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
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
                        <div id="price-preview" class="mt-8 bg-gradient-to-r from-primary/15 to-primary/5 border border-primary/30 rounded-2xl p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <div class="text-xs uppercase tracking-widest text-primary font-bold mb-2">Harga Per Meter</div>
                                    <div id="live-price" class="text-4xl font-serif text-white">Rp 0</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs uppercase tracking-widest text-gray-400 mb-2">Lokasi</div>
                                    <div id="live-location" class="text-lg text-white font-semibold">Dalam Kota</div>
                                </div>
                            </div>

                            <!-- Price Comparison Table -->
                            <div class="bg-black/20 rounded-xl p-5 mt-4">
                                <div class="text-xs uppercase tracking-widest text-gray-400 mb-4 font-medium">Perbandingan Harga Model</div>
                                <div class="space-y-2" id="price-comparison">
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
                    <div class="flex items-center justify-between mt-10 pt-6 border-t border-white/10 relative z-10">
                        <button type="button" id="btn-prev" onclick="prevStep()" class="hidden px-6 py-4 bg-white/5 border border-white/10 rounded-xl text-white text-sm font-semibold hover:bg-white/10 transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">arrow_back</span>
                            Kembali
                        </button>
                        <button type="button" id="btn-reset" onclick="resetCalculator()" class="px-6 py-4 bg-white/5 border border-white/10 rounded-xl text-white text-sm font-semibold hover:bg-white/10 transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">refresh</span>
                            Reset
                        </button>
                        <button type="button" id="btn-next" onclick="nextStep()" class="px-8 py-4 bg-primary text-black rounded-xl text-sm font-bold hover:bg-primary-hover transition-all shadow-lg shadow-primary/30 ml-auto flex items-center gap-2">
                            Lanjut
                            <span class="material-symbols-outlined text-lg">arrow_forward</span>
                        </button>
                        <button type="button" id="btn-calculate" onclick="calculateEstimate()" class="hidden px-8 py-4 bg-primary text-black rounded-xl text-sm font-bold hover:bg-primary-hover transition-all shadow-lg shadow-primary/30 ml-auto flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">calculate</span>
                            Hitung Estimasi
                        </button>
                    </div>
                </div>
            </div>

            <!-- Result Panel - Right Side -->
            <div class="lg:col-span-2">
                <div class="bg-gradient-to-br from-[#1a1d26] to-[#14171f] border border-white/10 rounded-2xl p-6 sm:p-8 shadow-2xl sticky top-24 overflow-hidden">
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
                                <span class="text-gray-400 text-sm">Biaya Tambahan</span>
                                <span id="summary-additional" class="text-white font-medium">-</span>
                            </div>
                        </div>

                        <!-- Badge -->
                        <div id="summary-badge" class="mb-6 text-center">
                            <span class="inline-block px-5 py-2 bg-primary/20 text-primary rounded-full text-sm font-bold uppercase tracking-wider">
                                Best Value
                            </span>
                        </div>

                        <!-- Grand Total -->
                        <div class="bg-gradient-to-r from-primary/25 to-primary/10 rounded-2xl p-6 mb-6">
                            <div class="text-center">
                                <span class="text-gray-300 text-xs uppercase tracking-widest block mb-3">Estimasi Total</span>
                                <span id="summary-total-range" class="text-3xl md:text-4xl font-serif text-white font-medium block">Rp 0</span>
                                <span class="text-gray-400 text-xs mt-3 block">*Estimasi ±10%, bukan harga final</span>
                            </div>
                        </div>

                        <!-- Summary Text -->
                        <div class="bg-white/[0.03] rounded-xl p-5 mb-6 border border-white/5">
                            <p id="summary-text" class="text-gray-300 text-sm leading-relaxed">-</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-3">
                            <button onclick="sendToWhatsApp()" class="w-full py-4 bg-[#25D366] text-white rounded-xl text-sm font-bold hover:bg-[#20BD5A] transition-all flex items-center justify-center gap-3 shadow-lg">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                                Kirim via WhatsApp
                            </button>
                            <button onclick="exportPDF()" class="w-full py-4 bg-white/10 border border-white/10 text-white rounded-xl text-sm font-bold hover:bg-white/20 transition-all flex items-center justify-center gap-3">
                                <span class="material-symbols-outlined text-xl">picture_as_pdf</span>
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
            updateProductPreview();
        });
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
            if (calcState.currentStep === 1) {
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
                    additional_costs: calcState.additionalCosts
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
        if (!calcState.result) return;
        const d = calcState.result;
        const text = encodeURIComponent(`Halo Home Putra Interior! 👋\n\nSaya tertarik dengan estimasi berikut:\n\n📍 Lokasi: ${d.location_label}\n📦 Produk: ${d.product}\n🪵 Material: ${d.material}\n🎨 Model: ${d.model}\n📏 Panjang: ${d.length} meter\n\n💰 Estimasi: ${formatCurrency(d.min_total)} – ${formatCurrency(d.max_total)}\n\nMohon informasi lebih lanjut. Terima kasih! 🙏`);
        window.open(`https://wa.me/6281234567890?text=${text}`, '_blank');
    }

    // Export PDF
    function exportPDF() {
        alert('Fitur export PDF akan segera tersedia. Sementara ini, Anda bisa mengambil screenshot atau mengirim via WhatsApp.');
    }

    // Initialize on load
    document.addEventListener('DOMContentLoaded', initCalculator);
</script>

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