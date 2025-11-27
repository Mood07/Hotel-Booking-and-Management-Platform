    </main>

    <!-- Footer -->
    <footer class="mt-5">
        <div class="container">
            <div class="row align-items-center py-4">
                <div class="col-md-4 text-center text-md-start mb-3 mb-md-0">
                    <h5 class="mb-0"><i class="bi bi-building"></i> <?php echo $settings['site_title'] ?? 'Grand Hotel'; ?></h5>
                </div>
                <div class="col-md-4 text-center mb-3 mb-md-0">
                    <a href="<?php echo SITE_URL; ?>" class="me-3">Home</a>
                    <a href="<?php echo SITE_URL; ?>rooms.php" class="me-3">Rooms</a>
                    <a href="<?php echo SITE_URL; ?>contact.php">Contact</a>
                </div>
                <div class="col-md-4 text-center text-md-end">
                    <span class="text-muted small">
                        <i class="bi bi-telephone"></i> <?php echo $settings['site_phone'] ?? ''; ?>
                        <i class="bi bi-envelope ms-2"></i> <?php echo $settings['site_email'] ?? ''; ?>
                    </span>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.2);">
            <div class="text-center py-3">
                <p class="mb-0 small" style="color: rgba(255,255,255,0.6);">&copy; <?php echo date('Y'); ?> <?php echo $settings['site_title'] ?? 'Grand Hotel'; ?>. All rights reserved.</p>
                <p class="mb-0 small" style="color: rgba(255,255,255,0.5);">Designed with ❤️ by <a href="https://github.com/Mood07" target="_blank" style="color: #c9a227;">Mood07</a></p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>