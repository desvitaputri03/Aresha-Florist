<?php $__env->startSection('title', 'Checkout - Aresha Florist'); ?>

<?php $__env->startSection('content'); ?>
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="py-3">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('cart.index')); ?>">Keranjang</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
    </div>
</nav>

<!-- Checkout Section -->
<section class="py-5">
    <div class="container">
        <h1 class="display-5 fw-bold mb-4">
            <i class="fas fa-credit-card me-3"></i>Checkout
        </h1>

        <form action="<?php echo e(route('cart.process-checkout')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="row">
                <!-- Customer Information -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-user me-2"></i>Informasi Pelanggan
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="nama" 
                                               name="nama" 
                                               value="<?php echo e(old('nama')); ?>" 
                                               required>
                                        <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" 
                                               class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="email" 
                                               name="email" 
                                               value="<?php echo e(old('email')); ?>" 
                                               required>
                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="telepon" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control <?php $__errorArgs = ['telepon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="telepon" 
                                               name="telepon" 
                                               value="<?php echo e(old('telepon')); ?>" 
                                               required>
                                        <?php $__errorArgs = ['telepon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                        <textarea class="form-control <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                  id="alamat" 
                                                  name="alamat" 
                                                  rows="3" 
                                                  required><?php echo e(old('alamat')); ?></textarea>
                                        <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="delivery_date" class="form-label">Tanggal Pengiriman <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control <?php $__errorArgs = ['delivery_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="delivery_date" 
                                       name="delivery_date" 
                                       value="<?php echo e(old('delivery_date')); ?>"
                                       required>
                                <?php $__errorArgs = ['delivery_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="form-text text-muted">Pilih tanggal barang diharapkan tiba di tujuan.</small>
                            </div>
                            <div class="mb-3">
                                <label for="recipient_name" class="form-label">Untuk Siapa <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['recipient_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="recipient_name" 
                                       name="recipient_name" 
                                       value="<?php echo e(old('recipient_name')); ?>" 
                                       placeholder="Nama penerima pesanan (mis: Ibu Budi)"
                                       required>
                                <?php $__errorArgs = ['recipient_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="mb-3">
                                <label for="event_type" class="form-label">Jenis Acara <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['event_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="event_type" 
                                       name="event_type" 
                                       value="<?php echo e(old('event_type')); ?>" 
                                       placeholder="Contoh: Wisuda, Khatam, Pembukaan Toko, dll."
                                       required>
                                <?php $__errorArgs = ['event_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="mb-3">
                                <label for="custom_message" class="form-label">Kata-kata Pesanan (Khusus Papan Bunga) <span class="text-danger">*</span></label>
                                <textarea class="form-control <?php $__errorArgs = ['custom_message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          id="custom_message" 
                                          name="custom_message" 
                                          rows="5" 
                                          placeholder="Isi pesan khusus untuk papan bunga di sini."><?php echo e(old('custom_message')); ?></textarea>
                                <?php $__errorArgs = ['custom_message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-credit-card me-2"></i>Metode Pembayaran
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash" <?php echo e(old('payment_method') == 'cash' ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="cash">
                                            <i class="fas fa-money-bill-wave me-2"></i><strong>Cash on Delivery (COD)</strong>
                                            <br><small class="text-muted">Bayar saat barang diterima</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="payment_method" id="transfer" value="transfer" <?php echo e(old('payment_method') == 'transfer' ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="transfer">
                                            <i class="fas fa-university me-2"></i><strong>Transfer Bank</strong>
                                            <br><small class="text-muted">Transfer ke rekening admin</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="transfer-info" class="alert alert-info" style="display: none;">
                                <h6><i class="fas fa-info-circle me-2"></i>Informasi Transfer:</h6>
                                <p class="mb-2"><strong>Bank:</strong> BCA</p>
                                <p class="mb-2"><strong>No. Rekening:</strong> 1234567890</p>
                                <p class="mb-2"><strong>Atas Nama:</strong> Aresha Florist</p>
                                <p class="mb-0"><strong>Catatan:</strong> Transfer sesuai total pesanan dan konfirmasi melalui WhatsApp</p>
                            </div>
                            
                            <div id="cash-info" class="alert alert-success">
                                <h6><i class="fas fa-truck me-2"></i>Cash on Delivery:</h6>
                                <p class="mb-0">Pembayaran dilakukan saat barang diterima. Driver akan memberikan struk pembayaran.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-receipt me-2"></i>Ringkasan Pesanan
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?php echo e($item->product->name); ?></h6>
                                    <small class="text-muted"><?php echo e($item->quantity); ?>x</small>
                                </div>
                                <div class="text-end">
                                    <?php
                                        $price = $item->product->harga_diskon ?? $item->product->harga;
                                        $itemTotal = $price * $item->quantity;
                                    ?>
                                    <div class="fw-bold">Rp<?php echo e(number_format($itemTotal, 0, ',', '.')); ?></div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span id="subtotal-display">Rp<?php echo e(number_format($total, 0, ',', '.')); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Ongkir:</span>
                                <span class="text-success" id="shipping-cost-display">Rp0</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <span class="h5 mb-0">Total:</span>
                                <span class="h5 text-primary fw-bold mb-0" id="grand-total-display">Rp<?php echo e(number_format($total, 0, ',', '.')); ?></span>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-check me-2"></i>Konfirmasi Pesanan
                            </button>
                            
                            <a href="<?php echo e(route('cart.index')); ?>" class="btn btn-outline-secondary w-100 mt-2">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Keranjang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<?php
    $googleMapsApiKey = \App\Models\Setting::getSetting('google_maps_api_key', '');
    $costPerKmOutsidePadang = \App\Models\Setting::getSetting('cost_per_km_outside_padang', 2000);
    $originAddress = 'Komplek kencana blok B 11 kel . gurun laweh kec .nanggalo Padang, Koto Padang, Sumatera Barat, Indonesia 25165';
?>

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e($googleMapsApiKey); ?>&libraries=places&callback=initMap" async defer></script>
<script>
// Toggle payment method info
document.addEventListener('DOMContentLoaded', function() {
    const cashRadio = document.getElementById('cash');
    const transferRadio = document.getElementById('transfer');
    const cashInfo = document.getElementById('cash-info');
    const transferInfo = document.getElementById('transfer-info');

    function togglePaymentInfo() {
        if (cashRadio.checked) {
            cashInfo.style.display = 'block';
            transferInfo.style.display = 'none';
        } else if (transferRadio.checked) {
            cashInfo.style.display = 'none';
            transferInfo.style.display = 'block';
        } else {
            // If no radio is checked, hide both info sections
            cashInfo.style.display = 'none';
            transferInfo.style.display = 'none';
        }
    }

    cashRadio.addEventListener('change', togglePaymentInfo);
    transferRadio.addEventListener('change', togglePaymentInfo);
    
    // Initial state based on previously selected value (if any)
    togglePaymentInfo();

    const alamatInput = document.getElementById('alamat');
    const calculatedDistanceKmInput = document.getElementById('calculated_distance_km');
    const alamatNotPadangInput = document.getElementById('alamat_not_padang');
    const shippingCostDisplay = document.getElementById('shipping-cost-display');
    const grandTotalDisplay = document.getElementById('grand-total-display');
    const subtotal = <?php echo e($total); ?>;
    const costPerKm = parseFloat('<?php echo e($costPerKmOutsidePadang); ?>');
    const originAddress = '<?php echo e($originAddress); ?>';

    let geocoder;
    let distanceMatrixService;

    // Function to initialize Google Maps services
    window.initMap = function() {
        geocoder = new google.maps.Geocoder();
        distanceMatrixService = new google.maps.DistanceMatrixService();
        // Initial calculation if address is already filled (e.g., old input)
        if (alamatInput.value) {
            calculateShipping();
        }
    };

    async function calculateShipping() {
        const destinationAddress = alamatInput.value;
        let shippingCost = 0;
        let distanceKm = 0;
        let isPadang = false;

        // Check if destination address contains 'Padang' (case-insensitive)
        if (destinationAddress.toLowerCase().includes('padang')) {
            isPadang = true;
            shippingCost = 0;
            distanceKm = 0;
            alamatNotPadangInput.value = 'false';
            updateDisplays(shippingCost, distanceKm);
            return;
        }

        // If not Padang, set alamat_not_padang to true for backend validation
        alamatNotPadangInput.value = 'true';

        if (!destinationAddress) {
            updateDisplays(0, 0);
            return;
        }

        try {
            const response = await distanceMatrixService.getDistanceMatrix({
                origins: [originAddress],
                destinations: [destinationAddress],
                travelMode: google.maps.TravelMode.DRIVING,
                unitSystem: google.maps.UnitSystem.METRIC,
            });

            const element = response.rows[0].elements[0];

            if (element.status === 'OK') {
                // Distance in meters, convert to kilometers
                distanceKm = element.distance.value / 1000;
                shippingCost = distanceKm * costPerKm;
            } else {
                console.error('Google Maps Distance Matrix Error:', element.status);
                // Fallback or error handling for when API call fails or address is invalid
                // For now, set a default high shipping cost or inform user
                shippingCost = 0; // Set to 0 if we can't calculate, or a default value like 50km * costPerKm
                distanceKm = 0; // No distance if API fails
                alert('Tidak dapat menghitung biaya pengiriman untuk alamat ini. Pastikan alamat lengkap dan benar.');
            }
        } catch (error) {
            console.error('Error calculating shipping cost:', error);
            shippingCost = 0; // Default to 0 on error
            distanceKm = 0;
            alert('Terjadi kesalahan saat menghitung ongkir. Pastikan Google Maps API Key Anda valid dan terkonfigurasi dengan benar.');
        }
        updateDisplays(shippingCost, distanceKm);
    }

    function updateDisplays(shippingCost, distanceKm) {
        const grandTotal = subtotal + shippingCost;
        shippingCostDisplay.textContent = 'Rp' + Math.round(shippingCost).toLocaleString('id-ID');
        grandTotalDisplay.textContent = 'Rp' + Math.round(grandTotal).toLocaleString('id-ID');
        calculatedDistanceKmInput.value = distanceKm.toFixed(2); // Store distance with 2 decimal places
    }

    // Trigger calculation when address changes (with a debounce to avoid too many API calls)
    let debounceTimeout;
    alamatInput.addEventListener('input', function() {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            calculateShipping();
        }, 1000); // Wait 1 second after last input to calculate
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.store', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vita\aresha-florist (2)\aresha-florist\resources\views/cart/checkout.blade.php ENDPATH**/ ?>