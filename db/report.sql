USE medigas;

CREATE OR REPLACE VIEW `availableSupplier` AS
  SELECT 
    kp.id,
    kp.uuid,
    kp.name,
    kp.position,
    kp.company_name,
    kp.address,
    kp.mobileno,
    kp.email,
    kp.bank_acc,
    kp.is_active,
    kp.jenis_usaha_id,
    ru.name AS jenis_usaha,
    kp.bank_id,
    rb.name AS bank
  FROM kontrak_penyedia kp
  JOIN ref_jenis_usaha ru ON kp.jenis_usaha_id = ru.id
  JOIN ref_bank rb ON kp.bank_id = rb.id
  WHERE kp.is_active = 1;

CREATE OR REPLACE VIEW `raw_daily_prices` AS
  SELECT
    1 AS gsid,
    harga_satuan as harga
  FROM
    tabel_kerja_sama
  WHERE
    CURRENT_DATE() BETWEEN tanggal_mulai AND tanggal_selesai
  UNION
  SELECT
    tki.gases AS gsid,
    tki.price as harga
  FROM
    tabel_konsolidasi_items tki
  JOIN 
    tabel_konsolidasi tk ON tki.konsolidasiKey = tk.id
  WHERE
    CURRENT_DATE() BETWEEN tk.tanggal_mulai AND tk.tanggal_selesai;

CREATE OR REPLACE VIEW `daily_prices` AS
  SELECT
    tg.id, tg.gases, tg.unit,
    IFNULL(tg.stock, 0) AS stock, IFNULL(rdp.harga, 0)  AS harga,
    IFNULL(tg.stock * rdp.harga, 0) as saldo
  FROM
    tabel_gases tg
  LEFT JOIN raw_daily_prices rdp ON rdp.gsid = tg.id;