/**
 * Kalkulator Estimasi Biaya - Home Putra Interior
 * File ini menangani semua logika interaksi kalkulator di sisi klien.
 */

// State Kalkulator untuk menyimpan pilihan pengguna
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

/**
 * Format Angka ke Rupiah
 * @param {number} amount 
 * @returns {string} format mata uang IDR
 */
function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(amount);
}

/**
 * Inisialisasi Kalkulator
 * Mengambil data awal (produk, model, dll) dari API
 */
async function initCalculator() {
    try {
        const response = await fetch(`${HP_SITE_URL}/api/calculator.php?action=init`);
        const result = await response.json();
        if (result.success) {
            // Map API response keys (snake_case) to JavaScript state keys (camelCase)
            calcState.data = {
                products: result.data.products || [],
                materials: result.data.materials || [],
                models: result.data.models || [],
                additionalCosts: result.data.additional_costs || []
            };
            renderProducts();
            renderModels();
            renderAdditionalCosts();
        }
    } catch (error) {
        console.error('Gagal memuat data kalkulator:', error);
    }
}

/**
 * Menampilkan Daftar Produk
 */
function renderProducts() {
    const grid = document.getElementById('product-grid');
    if (!grid) return;

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

    // Listener untuk perubahan produk
    document.querySelectorAll('input[name="product"]').forEach(input => {
        input.addEventListener('change', function () {
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

// Data gambar produk dan harga dasar
const productData = {
    1: {
        slug: 'kitchen-set',
        image: `${HP_SITE_URL}/assets/images/products/kitchen-set.png`,
        minPrice: 2000000
    },
    2: {
        slug: 'wardrobe',
        image: `${HP_SITE_URL}/assets/images/products/wardrobe.png`,
        minPrice: 2300000
    },
    3: {
        slug: 'backdrop-tv',
        image: `${HP_SITE_URL}/assets/images/products/backdrop-tv.png`,
        minPrice: 2100000
    },
    4: {
        slug: 'wallpanel',
        image: `${HP_SITE_URL}/assets/images/products/wallpanel.png`,
        minPrice: 850000
    }
};

/**
 * Update Preview Produk (Gambar & Badge)
 */
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

/**
 * Memuat Daftar Material Berdasarkan Produk
 * @param {number} productId 
 */
async function loadMaterialsForProduct(productId) {
    try {
        const response = await fetch(`${HP_SITE_URL}/api/calculator.php?action=get_materials&product_id=${productId}`);
        const result = await response.json();
        if (result.success) {
            calcState.data.materials = result.data;
            renderMaterials();
        }
    } catch (error) {
        console.error('Gagal memuat material:', error);
    }
}

/**
 * Menampilkan Daftar Material
 */
function renderMaterials() {
    const grid = document.getElementById('material-grid');
    if (!grid) return;

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
        input.addEventListener('change', function () {
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

/**
 * Update Preview Harga Real-time (Live Price)
 */
function updateLivePrice() {
    const livePrice = document.getElementById('live-price');
    const liveLocation = document.getElementById('live-location');
    const priceComparison = document.getElementById('price-comparison');

    if (!livePrice) return;

    // Fetch and display main price
    fetch(`${HP_SITE_URL}/api/calculator.php?action=get_price&product_id=${calcState.product}&material_id=${calcState.material}&model_id=${calcState.model}&location_type=${calcState.location}`)
        .then(res => res.json())
        .then(data => {
            if (data.price_per_meter) {
                livePrice.textContent = formatCurrency(data.price_per_meter);
            }
        });

    liveLocation.textContent = calcState.location === 'dalam_kota' ? 'Jawa Barat' : 'Luar Jawa Barat';

    // Build comparison HTML
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

    // Fetch prices for all models
    models.forEach((model, idx) => {
        fetch(`${HP_SITE_URL}/api/calculator.php?action=get_price&product_id=${calcState.product}&material_id=${calcState.material}&model_id=${idx + 1}&location_type=${calcState.location}`)
            .then(res => res.json())
            .then(data => {
                const el = document.getElementById(`price-model-${idx + 1}`);
                if (el && data.price_per_meter) {
                    el.textContent = formatCurrency(data.price_per_meter);
                }
            });
    });
}

/**
 * Menampilkan Daftar Model
 */
function renderModels() {
    const grid = document.getElementById('model-grid');
    if (!grid) return;

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
        input.addEventListener('change', function () {
            calcState.model = parseInt(this.value);
            document.querySelectorAll('.model-option > div').forEach(d => {
                d.classList.remove('border-primary', 'bg-primary/10');
                d.classList.add('border-white/10', 'bg-white/[0.02]');
            });
            this.nextElementSibling.classList.add('border-primary', 'bg-primary/10');
            this.nextElementSibling.classList.remove('border-white/10', 'bg-white/[0.02]');
            updateLivePrice(false); // Don't show loader when changing model
        });
    });
}

/**
 * Menampilkan Biaya Tambahan
 */
function renderAdditionalCosts() {
    const container = document.getElementById('additional-costs');
    if (!container) return;

    // Check if additionalCosts exists and is an array
    if (!calcState.data.additionalCosts || !Array.isArray(calcState.data.additionalCosts)) {
        console.log('No additional costs data available');
        return;
    }

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

/**
 * Menangani Perubahan Lokasi (Jabar / Luar Jabar)
 */
document.querySelectorAll('input[name="location"]').forEach(input => {
    input.addEventListener('change', function () {
        calcState.location = this.value;
        document.querySelectorAll('.location-option > div').forEach(d => {
            d.classList.remove('border-primary', 'bg-primary/10');
            d.classList.add('border-white/10');
            const icon = d.querySelector('.material-symbols-outlined');
            if (icon) {
                icon.classList.remove('text-primary');
                icon.classList.add('text-gray-400');
            }
            const container = d.querySelector('.w-12.h-12');
            if (container) {
                container.classList.remove('bg-primary/20');
                container.classList.add('bg-white/5');
            }
        });

        this.nextElementSibling.classList.add('border-primary', 'bg-primary/10');
        this.nextElementSibling.classList.remove('border-white/10');
        const activeIcon = this.nextElementSibling.querySelector('.material-symbols-outlined');
        if (activeIcon) {
            activeIcon.classList.add('text-primary');
            activeIcon.classList.remove('text-gray-400');
        }
        const activeContainer = this.nextElementSibling.querySelector('.w-12.h-12');
        if (activeContainer) {
            activeContainer.classList.add('bg-primary/20');
            activeContainer.classList.remove('bg-white/5');
        }

        // Tampilkan/Sembunyikan input lokasi yang relevan
        const jabarSection = document.getElementById('jabar-location-section');
        const luarJabarSection = document.getElementById('luar-jabar-location-section');

        if (this.value === 'dalam_kota') {
            if (jabarSection) jabarSection.classList.remove('hidden');
            if (luarJabarSection) luarJabarSection.classList.add('hidden');
        } else {
            if (jabarSection) jabarSection.classList.add('hidden');
            if (luarJabarSection) luarJabarSection.classList.remove('hidden');
        }

        updateLivePrice();
    });
});

// Dropdown Lokasi Jabar (Searchable)
const jabarInput = document.getElementById('kota-kabupaten-search');
const jabarDropdown = document.getElementById('jabar-dropdown');
const jabarArrow = document.getElementById('jabar-arrow');
const jabarNoResults = document.getElementById('jabar-no-results');

if (jabarInput) {
    jabarInput.removeAttribute('readonly');
    jabarInput.addEventListener('focus', openJabarDropdown);
    jabarInput.addEventListener('click', (e) => {
        e.stopPropagation();
        openJabarDropdown();
    });
    jabarInput.addEventListener('input', function () {
        filterJabarOptions(this.value.toLowerCase());
        openJabarDropdown();
    });
}

function openJabarDropdown() {
    if (jabarDropdown) jabarDropdown.classList.remove('hidden');
    if (jabarArrow) jabarArrow.querySelector('span').style.transform = 'rotate(180deg)';
    if (jabarInput) jabarInput.classList.add('border-primary');
}

function closeJabarDropdown() {
    if (jabarDropdown) jabarDropdown.classList.add('hidden');
    if (jabarArrow) jabarArrow.querySelector('span').style.transform = 'rotate(0deg)';
    if (jabarInput) jabarInput.classList.remove('border-primary');
}

function filterJabarOptions(query) {
    let visibleCount = 0;
    const jabarOptions = document.querySelectorAll('.jabar-option');
    const jabarGroups = document.querySelectorAll('.jabar-group');

    jabarOptions.forEach(option => {
        const text = option.textContent.toLowerCase();
        if (text.includes(query)) {
            option.classList.remove('hidden');
            visibleCount++;
        } else {
            option.classList.add('hidden');
        }
    });

    jabarGroups.forEach(group => {
        const visibleInGroup = group.querySelectorAll('.jabar-option:not(.hidden)').length;
        group.classList.toggle('hidden', visibleInGroup === 0);
    });

    if (jabarNoResults) jabarNoResults.classList.toggle('hidden', visibleCount > 0);
}

// Delegate selection click
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('jabar-option')) {
        const value = e.target.dataset.value;
        jabarInput.value = value;
        calcState.kotaKabupaten = value;
        closeJabarDropdown();
        filterJabarOptions('');
    }

    const container = document.getElementById('jabar-dropdown-container');
    if (container && !container.contains(e.target)) {
        closeJabarDropdown();
    }
});

// Penanganan Ukuran (Panjang)
const lengthInput = document.getElementById('length-input');
const lengthSlider = document.getElementById('length-slider');

if (lengthInput) {
    lengthInput.addEventListener('input', function () {
        let val = parseFloat(this.value) || 0;
        if (val > 50) val = 50;
        if (val < 0) val = 0;
        calcState.length = val;
        if (lengthSlider) lengthSlider.value = Math.min(val, 20);
    });
}

if (lengthSlider) {
    lengthSlider.addEventListener('input', function () {
        calcState.length = parseFloat(this.value);
        if (lengthInput) lengthInput.value = this.value;
    });
}

function adjustLength(delta) {
    let newVal = calcState.length + delta;
    if (newVal < 0.5) newVal = 0.5;
    if (newVal > 50) newVal = 50;
    calcState.length = newVal;
    if (lengthInput) lengthInput.value = newVal;
    if (lengthSlider) lengthSlider.value = Math.min(newVal, 20);
}

/**
 * Navigasi Step Kalkulator
 */
function updateStepIndicators() {
    for (let i = 1; i <= 3; i++) {
        const indicator = document.getElementById(`step${i}-indicator`);
        const progress = document.getElementById(`step${i}-progress`);

        if (!indicator) continue;

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
    const stepEl = document.getElementById(`step${step}`);
    if (stepEl) stepEl.classList.remove('hidden');

    const btnPrev = document.getElementById('btn-prev');
    const btnNext = document.getElementById('btn-next');
    const btnCalc = document.getElementById('btn-calculate');

    if (btnPrev) btnPrev.classList.toggle('hidden', step === 1);
    if (btnNext) btnNext.classList.toggle('hidden', step === 3);
    if (btnCalc) btnCalc.classList.toggle('hidden', step !== 3);

    updateStepIndicators();
}

function nextStep() {
    if (calcState.currentStep < 3) {
        // Validasi Step 1
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
                if (calcState.location === 'dalam_kota') document.getElementById('kota-kabupaten-search').focus();
                else document.getElementById('kota-input').focus();
                return;
            }

            // Pindahkan ke Step 2 terlebih dahulu agar loader terlihat
            calcState.currentStep++;
            showStep(calcState.currentStep);

            // Kemudian load materials (loader akan muncul saat Step 2 sudah visible)
            loadMaterialsForProduct(calcState.product);
            return;
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

    if (lengthInput) lengthInput.value = 3;
    if (lengthSlider) lengthSlider.value = 3;

    document.querySelectorAll('input[type="checkbox"]').forEach(cb => {
        if (cb.id !== 'include-shipping') cb.checked = false;
    });
    const includeShipping = document.getElementById('include-shipping');
    if (includeShipping) includeShipping.checked = true;

    const placeholder = document.getElementById('summary-placeholder');
    const content = document.getElementById('summary-content');
    if (placeholder) placeholder.classList.remove('hidden');
    if (content) content.classList.add('hidden');

    showStep(1);
}

/**
 * Kirim Data ke API untuk Kalkulasi
 */
async function calculateEstimate() {
    const additionalCostIds = [];
    document.querySelectorAll('input[name="additional_cost"]:checked').forEach(cb => {
        additionalCostIds.push(parseInt(cb.value));
    });
    calcState.additionalCosts = additionalCostIds;
    const includeShippingCb = document.getElementById('include-shipping');
    calcState.includeShipping = includeShippingCb ? includeShippingCb.checked : true;

    // Ambil alamat sesuai pilihan lokasi
    let alamat = '';
    if (calcState.location === 'dalam_kota') {
        alamat = document.getElementById('kota-kabupaten-search').value || '';
    } else {
        const provinsi = document.getElementById('provinsi-input').value || '';
        const kota = document.getElementById('kota-input').value || '';
        alamat = [kota, provinsi].filter(Boolean).join(', ');
    }

    try {
        const nameInput = document.getElementById('customer-name');
        const response = await fetch(`${HP_SITE_URL}/api/calculator.php?action=calculate`, {
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
                nama: nameInput ? nameInput.value.trim() : 'Pelanggan'
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
        console.error('Kesalahan kalkulasi:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    }
}

/**
 * Menampilkan Hasil Kalkulasi ke Panel Ringkasan
 */
function displayResult(data) {
    const placeholder = document.getElementById('summary-placeholder');
    const content = document.getElementById('summary-content');
    if (placeholder) placeholder.classList.add('hidden');
    if (content) content.classList.remove('hidden');

    document.getElementById('summary-location').textContent = data.location_label;
    document.getElementById('summary-product').textContent = data.product;
    document.getElementById('summary-material').textContent = data.material;
    document.getElementById('summary-model').textContent = data.model;
    document.getElementById('summary-length').textContent = data.length + ' meter';
    document.getElementById('summary-price-per-meter').textContent = formatCurrency(data.price_per_meter);
    document.getElementById('summary-subtotal').textContent = formatCurrency(data.subtotal);
    document.getElementById('summary-shipping').textContent = data.shipping_label;

    const addRow = document.getElementById('summary-additional-row');
    const addVal = document.getElementById('summary-additional');
    if (data.additional_costs > 0) {
        if (addRow) addRow.classList.remove('hidden');
        if (addVal) addVal.textContent = formatCurrency(data.additional_costs);
    } else if (addRow) {
        addRow.classList.add('hidden');
    }

    const badgeColors = {
        'Ekonomis': 'bg-green-500/20 text-green-400',
        'Best Value': 'bg-primary/20 text-primary',
        'Premium': 'bg-purple-500/20 text-purple-400'
    };

    const summaryBadge = document.getElementById('summary-badge');
    if (summaryBadge) {
        summaryBadge.innerHTML = `<span class="inline-block px-5 py-2 ${badgeColors[data.badge] || badgeColors['Best Value']} rounded-full text-sm font-bold uppercase tracking-wider">${data.badge}</span>`;
    }

    document.getElementById('summary-total-range').textContent = formatCurrency(data.min_total) + ' – ' + formatCurrency(data.max_total);
    document.getElementById('summary-text').textContent = data.summary;
}

/**
 * Mengirim Hasil Estimasi via WhatsApp
 */
function sendToWhatsApp() {
    if (!calcState.result) {
        alert('Silakan hitung estimasi terlebih dahulu');
        return;
    }
    const d = calcState.result;

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

    const nameInput = document.getElementById('customer-name');
    const customerName = nameInput ? nameInput.value : 'Pelanggan';
    const text = encodeURIComponent(`Halo Home Putra Interior! 👋\n\nSaya ${customerName}, saya telah menggunakan Kalkulator Estimasi di website dan tertarik dengan rincian berikut:\n\n${details}\n\nMohon informasi lebih lanjut untuk survey lokasi. Terima kasih! 🙏`);

    // Gunakan nomor dari variabel global atau fallback ke default
    const waNumber = typeof HP_WHATSAPP_NUMBER !== 'undefined' ? HP_WHATSAPP_NUMBER : '6283137554972';
    window.open(`https://wa.me/${waNumber}?text=${text}`, '_blank');
}

/**
 * Export Hasil ke PDF Premium
 */
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
    const goldAccent = [197, 158, 62];
    const darkNavy = [15, 23, 42];
    const darkGray = [51, 65, 85];
    const lightGray = [248, 250, 252];
    const borderGray = [226, 232, 240];

    // --- 1. HEADER BRANDING ---
    doc.setFillColor(...goldAccent);
    doc.rect(0, 0, 210, 2, 'F');

    doc.setFillColor(...darkNavy);
    doc.roundedRect(15, 12, 12, 12, 2, 2, 'F');
    doc.setTextColor(255, 255, 255);
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(10);
    doc.text('H', 19.5, 20);

    doc.setTextColor(...darkNavy);
    doc.setFontSize(18);
    doc.setFont('times', 'bold');
    doc.text('Home Putra', 32, 19);
    doc.setFont('times', 'italic');
    doc.setTextColor(...goldAccent);
    doc.text('Interior', 68, 19);

    doc.setFont('helvetica', 'normal');
    doc.setFontSize(7.5);
    doc.setTextColor(...darkGray);
    doc.text('PREMIUM INTERIOR DESIGN & FURNITURE STUDIO', 32, 24);

    const refNo = 'EST/' + new Date().getFullYear() + '/' + Math.random().toString(36).substr(2, 5).toUpperCase();
    doc.setFontSize(8);
    doc.text('ESTIMASI PENAWARAN', 195, 17, {
        align: 'right'
    });
    doc.text(`Ref No: ${refNo}`, 195, 21.5, {
        align: 'right'
    });
    doc.text(`Tanggal: ${new Date().toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})}`, 195, 26, {
        align: 'right'
    });

    doc.setDrawColor(...borderGray);
    doc.line(15, 35, 195, 35);

    // --- 2. INFORMASI KLIEN & PROYEK ---
    doc.setTextColor(...darkNavy);
    doc.setFontSize(10);
    doc.setFont('helvetica', 'bold');
    doc.text('Informasi Klien', 15, 45);
    doc.text('Spesifikasi Utama', 110, 45);

    doc.setFillColor(...lightGray);
    doc.roundedRect(15, 48, 85, 25, 1, 1, 'F');
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(8.5);
    doc.setTextColor(...darkGray);

    const nameInput = document.getElementById('customer-name');
    const customerName = nameInput ? nameInput.value : 'Walk-in Customer';
    doc.text([
        `Nama: ${customerName}`,
        `Lokasi: ${data.location_label}`,
        `Status: Estimasi Awal`
    ], 20, 55);

    doc.setFillColor(...lightGray);
    doc.roundedRect(110, 48, 85, 25, 1, 1, 'F');
    doc.text([
        `Produk: ${data.product}`,
        `Material: ${data.material}`,
        `Model: ${data.model}`,
        `Dimensi: ${data.length} Meter Lari`
    ], 115, 53.5);

    // --- 3. TABEL RINCIAN BIAYA ---
    doc.setFontSize(10);
    doc.setFont('helvetica', 'bold');
    doc.setTextColor(...darkNavy);
    doc.text('Rincian Pekerjaan', 15, 85);

    const tableBody = [
        ['01', `${data.product} - Custom Furniture\nSpec: ${data.material} • ${data.model}`, `${data.length} m`, formatCurrency(data.price_per_meter), formatCurrency(data.subtotal)]
    ];

    if (data.additional_details && data.additional_details.length > 0) {
        data.additional_details.forEach((item, idx) => {
            tableBody.push(['02.' + (idx + 1), item.name, '1 Lot', '-', formatCurrency(item.amount)]);
        });
    }

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
        didDrawPage: function (data) {
            doc.setDrawColor(...borderGray);
            doc.setLineWidth(0.1);
            doc.line(15, data.cursor.y, 195, data.cursor.y);
        }
    });

    // --- 4. GRAND TOTAL ---
    let currentY = doc.lastAutoTable.finalY + 10;
    if (currentY > 230) {
        doc.addPage();
        currentY = 20;
    }

    const totalCardWidth = 85;
    const totalCardX = 110;

    doc.setFillColor(...lightGray);
    doc.rect(totalCardX, currentY, totalCardWidth, 40, 'F');
    doc.setFillColor(...goldAccent);
    doc.rect(totalCardX + totalCardWidth - 2, currentY, 2, 40, 'F');

    doc.setTextColor(...darkGray);
    doc.setFontSize(8);
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

    // --- 5. SYARAT & FOOTER ---
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

    doc.setFontSize(8.5);
    doc.setTextColor(...darkNavy);
    doc.text('Dibuat Oleh,', 150, currentY + 50);
    doc.setFont('times', 'italic');
    doc.text('Sistem Kalkulator Digital', 150, currentY + 65);
    doc.setDrawColor(...borderGray);
    doc.line(150, currentY + 67, 190, currentY + 67);
    doc.setFontSize(7);
    doc.text('Home Putra Interior Team', 150, currentY + 71);

    doc.setFillColor(...darkNavy);
    doc.rect(0, 285, 210, 12, 'F');
    doc.setTextColor(255, 255, 255);
    doc.setFontSize(7);
    doc.text('QUALITY INTERIOR FOR YOUR LIFESTYLE | WWW.HOMEPUTRAINTERIOR.COM', 105, 292.5, {
        align: 'center'
    });

    doc.save(`${refNo.replace(/\//g, '-')}-HomePutra.pdf`);
}

// Jalankan inisialisasi saat halaman dimuat
document.addEventListener('DOMContentLoaded', initCalculator);