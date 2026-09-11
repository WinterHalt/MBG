USE medigas;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `tabel_penerimaan_konsolidasi_items`;
DROP TABLE IF EXISTS `tabel_penerimaan_konsolidasi`;
DROP TABLE IF EXISTS `tabel_order_konsolidasi_items`;
DROP TABLE IF EXISTS `tabel_order_konsolidasi`;
DROP TABLE IF EXISTS `tabel_surat_konsolidasi_items`;
DROP TABLE IF EXISTS `tabel_surat_konsolidasi`;
DROP TABLE IF EXISTS `tabel_konsolidasi_items`;
DROP TABLE IF EXISTS `tabel_konsolidasi`;
DROP TABLE IF EXISTS `tabel_penerimaan_ipsrs`;
DROP TABLE IF EXISTS `tabel_order_kerjasama`;
DROP TABLE IF EXISTS `tabel_surat_kerjasama`;
DROP TABLE IF EXISTS `tabel_kerja_sama_history`;
DROP TABLE IF EXISTS `tabel_adendum_kerjasama`;
DROP TABLE IF EXISTS `tabel_kerja_sama`;
DROP TABLE IF EXISTS `tabel_pengeluaran_detail`;
DROP TABLE IF EXISTS `tabel_pengeluaran`;
DROP TABLE IF EXISTS `tabel_logging_detail`;
DROP TABLE IF EXISTS `tabel_logging`;
DROP TABLE IF EXISTS `tabel_gases`;

CREATE TABLE `tabel_gases` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `gases` VARCHAR(150) NOT NULL,
  `unit` VARCHAR(25) NOT NULL,
  `stock` INT NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP NULL DEFAULT NULL,
  `deleted_by` VARCHAR(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  UNIQUE KEY `uq_gases_name` (`gases`),
  CONSTRAINT `fk_gases_deleted_by`
    FOREIGN KEY (`deleted_by`)
    REFERENCES `staff` (`staff_id`)
    ON UPDATE CASCADE
    ON DELETE SET NULL
);

CREATE TABLE `tabel_logging` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `tanggal` DATE NOT NULL,
  `user` VARCHAR(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_logging_tanggal` (`tanggal`),
  CONSTRAINT `fk_logging_user`
    FOREIGN KEY (`user`)
    REFERENCES `staff` (`staff_id`)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

CREATE TABLE `tabel_logging_detail` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `loggingKey` INT NOT NULL,
  `gases` INT NOT NULL,
  `sistem` INT NOT NULL DEFAULT 0,
  `fisik` INT NOT NULL DEFAULT 0,
  `selisih` INT NOT NULL DEFAULT 0,
  `price` DECIMAL(15,2) NOT NULL DEFAULT 0,
  UNIQUE KEY `uq_logging_gas` (`loggingKey`, `gases`),
  CONSTRAINT `fk_logging_detail_logging`
    FOREIGN KEY (`loggingKey`)
    REFERENCES `tabel_logging` (`id`)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT `fk_logging_detail_gas`
    FOREIGN KEY (`gases`)
    REFERENCES `tabel_gases` (`id`)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

CREATE TABLE `tabel_pengeluaran` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `tanggal` DATE NOT NULL,
  `user` VARCHAR(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_pengeluaran_tanggal` (`tanggal`),
  CONSTRAINT `fk_pengeluaran_user`
    FOREIGN KEY (`user`)
    REFERENCES `staff` (`staff_id`)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

CREATE TABLE `tabel_pengeluaran_detail` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `pengeluaranKey` INT NOT NULL,
  `gases` INT NOT NULL,
  `pagi` DECIMAL(10,4) NOT NULL DEFAULT 0.0000,
  `sore` DECIMAL(10,4) NOT NULL DEFAULT 0.0000,
  `malam` DECIMAL(10,4) NOT NULL DEFAULT 0.0000,
  `total` DECIMAL(10,4) NOT NULL DEFAULT 0.0000,
  UNIQUE KEY `uq_pengeluaran_gas` (`pengeluaranKey`, `gases`),
  CONSTRAINT `fk_pengeluaran_detail_id`
    FOREIGN KEY (`pengeluaranKey`)
    REFERENCES `tabel_pengeluaran` (`id`)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT `fk_pengeluaran_gas_id`
    FOREIGN KEY (`gases`)
    REFERENCES `tabel_gases` (`id`)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

CREATE TABLE `tabel_kerja_sama` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `supplier` INT NOT NULL,
  `gases` INT NOT NULL,
  `judul` VARCHAR(255) NOT NULL,
  `nomor_hukum` VARCHAR(30) NOT NULL,
  `nomor_kontrak` VARCHAR(30) NOT NULL,
  `tanggal_mulai` DATE NOT NULL,
  `tanggal_selesai` DATE NOT NULL,
  `harga_satuan` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `note` TEXT NULL,
  `status` ENUM('draft','pending_approval','active','expiring','expired','terminated') NOT NULL DEFAULT 'draft',
  `urlfile` VARCHAR(255) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP NULL DEFAULT NULL,
  `deleted_by` VARCHAR(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  UNIQUE KEY `uq_kerja_sama_nomor_hukum` (`nomor_hukum`),
  UNIQUE KEY `uq_kerja_sama_nomor_kontrak` (`nomor_kontrak`),
  KEY `idx_kerja_sama_tanggal` (`tanggal_mulai`, `tanggal_selesai`),
  KEY `idx_kerja_sama_status` (`status`),
  KEY `idx_kerja_sama_gases` (`gases`),
  CONSTRAINT `fk_kerja_sama_supplier`
    FOREIGN KEY (`supplier`)
    REFERENCES `kontrak_penyedia` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_kerja_sama_gases`
    FOREIGN KEY (`gases`)
    REFERENCES `tabel_gases` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_kerja_sama_deleted_by`
    FOREIGN KEY (`deleted_by`)
    REFERENCES `staff` (`staff_id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE
);

CREATE TABLE `tabel_adendum_kerjasama` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `kerjaSamaKey` INT NOT NULL,
  `tanggal` DATE NOT NULL,
  `alasan` TEXT NULL,
  `urlfile` VARCHAR(255) NULL DEFAULT NULL,
  `user` VARCHAR(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `register_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_adendum_kerja_sama` (`kerjaSamaKey`),
  KEY `idx_adendum_tanggal` (`tanggal`),
  CONSTRAINT `fk_adendum_kerja_sama`
    FOREIGN KEY (`kerjaSamaKey`)
    REFERENCES `tabel_kerja_sama` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_adendum_user`
    FOREIGN KEY (`user`)
    REFERENCES `staff` (`staff_id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
);

CREATE TABLE `tabel_kerja_sama_history` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `kerjaSamaKey` INT NOT NULL,
  `judul` VARCHAR(255) NOT NULL,
  `gases` INT NOT NULL,
  `tanggal_mulai` DATE NOT NULL,
  `tanggal_selesai` DATE NOT NULL,
  `harga_satuan` DECIMAL(15,2) NOT NULL,
  `note` TEXT NULL,
  `snapshot_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `snapshot_by` VARCHAR(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `adendumKeyTrigger` INT DEFAULT NULL,
  KEY `idx_history_kerja_sama` (`kerjaSamaKey`),
  KEY `idx_history_adendum_trigger` (`adendumKeyTrigger`),
  KEY `idx_history_gases` (`gases`),
  CONSTRAINT `fk_history_kerja_sama`
    FOREIGN KEY (`kerjaSamaKey`)
    REFERENCES `tabel_kerja_sama` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_history_adendum_trigger`
    FOREIGN KEY (`adendumKeyTrigger`)
    REFERENCES `tabel_adendum_kerjasama` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_history_snapshot_by`
    FOREIGN KEY (`snapshot_by`)
    REFERENCES `staff` (`staff_id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_history_gases`
    FOREIGN KEY (`gases`)
    REFERENCES `tabel_gases` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
);

CREATE TABLE `tabel_surat_kerjasama` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `kerjaSamaKey` INT NOT NULL,
  `tanggal_mulai` DATE NOT NULL,
  `tanggal_selesai` DATE NOT NULL,
  `estimasi_kuantitas` DECIMAL(15,4) NOT NULL DEFAULT 0,
  `estimasi_saldo` DECIMAL(15,4) NOT NULL DEFAULT 0,
  `tanggal_issued` DATE NOT NULL,
  `urlfile` VARCHAR(255) NULL DEFAULT NULL,
  `user` VARCHAR(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_surat_kerja_sama` (`kerjaSamaKey`),
  KEY `idx_surat_tanggal` (`tanggal_mulai`, `tanggal_selesai`),
  CONSTRAINT `fk_surat_kerja_sama`
    FOREIGN KEY (`kerjaSamaKey`)
    REFERENCES `tabel_kerja_sama` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_surat_user`
    FOREIGN KEY (`user`)
    REFERENCES `staff` (`staff_id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
);

CREATE TABLE `tabel_order_kerjasama` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `suratKey` INT NOT NULL,
  `tanggal_order` DATE NOT NULL,
  `kuantitas` DECIMAL(15,4) NOT NULL DEFAULT 0,
  `saldo` DECIMAL(15,4) NOT NULL DEFAULT 0,
  `isactive` TINYINT(1) NOT NULL DEFAULT 1,
  `tanggal_issued` DATE NOT NULL,
  `user` VARCHAR(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_order_surat` (`suratKey`),
  KEY `idx_order_isactive` (`isactive`),
  CONSTRAINT `fk_order_surat`
    FOREIGN KEY (`suratKey`)
    REFERENCES `tabel_surat_kerjasama` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_order_user`
    FOREIGN KEY (`user`)
    REFERENCES `staff` (`staff_id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
);

CREATE TABLE `tabel_penerimaan_ipsrs` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `orderKey` INT NOT NULL,
  `tanggal` DATE NOT NULL,
  `user` VARCHAR(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `telemetryawal` DECIMAL(15,4) NOT NULL DEFAULT 0,
  `telemetryakhir` DECIMAL(15,4) NOT NULL DEFAULT 0,
  `selisih` DECIMAL(15,4) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_penerimaan_ipsrs_order` (`orderKey`),
  KEY `idx_penerimaan_ipsrs_tanggal` (`tanggal`),
  CONSTRAINT `fk_penerimaan_ipsrs_order`
    FOREIGN KEY (`orderKey`)
    REFERENCES `tabel_order_kerjasama` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_penerimaan_ipsrs_user`
    FOREIGN KEY (`user`)
    REFERENCES `staff` (`staff_id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
);

CREATE TABLE `tabel_konsolidasi` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nomor_konsolidasi` VARCHAR(50) NOT NULL,
  `judul` VARCHAR(250) NOT NULL,
  `tanggal_mulai` DATE NOT NULL,
  `tanggal_selesai` DATE NOT NULL,
  `note` TEXT NULL,
  `status` ENUM('draft','pending_approval','active','expiring','expired','terminated') NOT NULL DEFAULT 'draft',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP NULL DEFAULT NULL,
  `deleted_by` VARCHAR(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  UNIQUE KEY `uq_konsolidasi_nomor` (`nomor_konsolidasi`),
  KEY `idx_konsolidasi_tanggal` (`tanggal_mulai`, `tanggal_selesai`),
  KEY `idx_konsolidasi_status` (`status`),
  CONSTRAINT `fk_konsolidasi_deleted_by`
    FOREIGN KEY (`deleted_by`)
    REFERENCES `staff` (`staff_id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE
);

CREATE TABLE `tabel_konsolidasi_items` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `konsolidasiKey` INT NOT NULL,
  `gases` INT NOT NULL,
  `price` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `estimasi_kuantitas` DECIMAL(15,4) NOT NULL DEFAULT 0,
  UNIQUE KEY `uq_konsolidasi_gas` (`konsolidasiKey`, `gases`),
  KEY `idx_items_gases` (`gases`),
  CONSTRAINT `fk_items_konsolidasi`
    FOREIGN KEY (`konsolidasiKey`)
    REFERENCES `tabel_konsolidasi` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_items_gases`
    FOREIGN KEY (`gases`)
    REFERENCES `tabel_gases` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
);

CREATE TABLE `tabel_surat_konsolidasi` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `konsolidasiKey` INT NOT NULL,
  `tanggal_mulai` DATE NOT NULL,
  `tanggal_selesai` DATE NOT NULL,
  `tanggal_issued` DATE NOT NULL,
  `user` VARCHAR(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_surat_konsolidasi_konsolidasi` (`konsolidasiKey`),
  KEY `idx_surat_konsolidasi_tanggal` (`tanggal_mulai`, `tanggal_selesai`),
  CONSTRAINT `fk_surat_konsolidasi_konsolidasi`
    FOREIGN KEY (`konsolidasiKey`)
    REFERENCES `tabel_konsolidasi` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_surat_konsolidasi_user`
    FOREIGN KEY (`user`)
    REFERENCES `staff` (`staff_id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
);

CREATE TABLE `tabel_surat_konsolidasi_items` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `suratKonsolidasiKey` INT NOT NULL,
  `gases` INT NOT NULL,
  `price` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `kuantitas` DECIMAL(15,4) NOT NULL DEFAULT 0,
  `saldo` DECIMAL(15,4) NOT NULL DEFAULT 0,
  UNIQUE KEY `uq_surat_konsolidasi_gas` (`suratKonsolidasiKey`, `gases`),
  KEY `idx_surat_konsolidasi_items_gases` (`gases`),
  CONSTRAINT `fk_surat_konsolidasi_items_surat`
    FOREIGN KEY (`suratKonsolidasiKey`)
    REFERENCES `tabel_surat_konsolidasi` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_surat_konsolidasi_items_gases`
    FOREIGN KEY (`gases`)
    REFERENCES `tabel_gases` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
);

CREATE TABLE `tabel_order_konsolidasi` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `suratKonsolidasiKey` INT NOT NULL,
  `tanggal_order` DATE NOT NULL,
  `user` VARCHAR(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `isactive` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_order_konsolidasi_surat` (`suratKonsolidasiKey`),
  KEY `idx_order_konsolidasi_isactive` (`isactive`),
  CONSTRAINT `fk_order_konsolidasi_surat`
    FOREIGN KEY (`suratKonsolidasiKey`)
    REFERENCES `tabel_surat_konsolidasi` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_order_konsolidasi_user`
    FOREIGN KEY (`user`)
    REFERENCES `staff` (`staff_id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
);

CREATE TABLE `tabel_order_konsolidasi_items` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `orderKonsolidasiKey` INT NOT NULL,
  `gases` INT NOT NULL,
  `price` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `kuantitas` DECIMAL(15,4) NOT NULL DEFAULT 0,
  `saldo` DECIMAL(15,4) NOT NULL DEFAULT 0,
  UNIQUE KEY `uq_order_konsolidasi_gas` (`orderKonsolidasiKey`, `gases`),
  KEY `idx_order_konsolidasi_items_gases` (`gases`),
  CONSTRAINT `fk_order_konsolidasi_items_order`
    FOREIGN KEY (`orderKonsolidasiKey`)
    REFERENCES `tabel_order_konsolidasi` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_order_konsolidasi_items_gases`
    FOREIGN KEY (`gases`)
    REFERENCES `tabel_gases` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
);

CREATE TABLE `tabel_penerimaan_konsolidasi` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `orderKonsolidasiKey` INT NOT NULL,
  `tanggal` DATE NOT NULL,
  `user` VARCHAR(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_penerimaan_konsolidasi_order` (`orderKonsolidasiKey`),
  KEY `idx_penerimaan_konsolidasi_tanggal` (`tanggal`),
  CONSTRAINT `fk_penerimaan_konsolidasi_order`
    FOREIGN KEY (`orderKonsolidasiKey`)
    REFERENCES `tabel_order_konsolidasi` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_penerimaan_konsolidasi_user`
    FOREIGN KEY (`user`)
    REFERENCES `staff` (`staff_id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
);

CREATE TABLE `tabel_penerimaan_konsolidasi_items` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `penerimaanKonsolidasiKey` INT NOT NULL,
  `gases` INT NOT NULL,
  `price` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `jumlah` DECIMAL(15,4) NOT NULL DEFAULT 0,
  `saldo` DECIMAL(15,4) NOT NULL DEFAULT 0,
  UNIQUE KEY `uq_penerimaan_konsolidasi_gas` (`penerimaanKonsolidasiKey`, `gases`),
  KEY `idx_penerimaan_konsolidasi_items_gases` (`gases`),
  CONSTRAINT `fk_penerimaan_konsolidasi_items_penerimaan`
    FOREIGN KEY (`penerimaanKonsolidasiKey`)
    REFERENCES `tabel_penerimaan_konsolidasi` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_penerimaan_konsolidasi_items_gases`
    FOREIGN KEY (`gases`)
    REFERENCES `tabel_gases` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
);

SET FOREIGN_KEY_CHECKS = 1;