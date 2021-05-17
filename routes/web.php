<?php
Route::get('/', 'AllPageController@utama');
Route::get('/home', 'AllPageController@home');
Route::post('/login', 'AllPageController@login_action');
Route::get('/logout', 'AllPageController@logout');
Route::get('/register', 'AllPageController@register');
Route::post('/register/submit','AllPageController@register_submit');
Route::get('/penawaran', 'AllPageController@index');
Route::get('/po', 'AllPageController@po');
Route::post('/po/id-supplier', 'AllPageController@po_id_supplier')->name('po.id_supplier');
Route::get('/master/penawaran/paragraf', 'AllPageController@master');
Route::get('/master/penawaran/kategori', 'AllPageController@master_penawaran_kategori')->name('master_penawaran.kategori');
Route::post('/master/penawaran/kategori/status/tambah', 'AllPageController@master_penawaran_kategori_status_tambah')->name('master_penawaran.kategori_status_tambah');
Route::post('/master/penawaran/kategori/status/hapus', 'AllPageController@master_penawaran_kategori_status_hapus')->name('master_penawaran.kategori_status_hapus');
Route::post('/master/penawaran/kategori/payment/tambah', 'AllPageController@master_penawaran_kategori_payment_tambah')->name('master_penawaran.kategori_payment_tambah');
Route::post('/master/penawaran/kategori/payment/hapus', 'AllPageController@master_penawaran_kategori_payment_hapus')->name('master_penawaran.kategori_payment_hapus');
Route::get('/master/penawaran/rule', 'MasterRule@master_penawaran_rule')->name('master_penawaran.rule');
Route::post('/master/penawaran/rule/tambah', 'MasterRule@master_penawaran_rule_tambah')->name('master_penawaran.rule_tambah');
Route::post('/master/penawaran/rule/edit', 'MasterRule@master_penawaran_rule_edit')->name('master_penawaran.rule_edit');
Route::post('/master/penawaran/rule/hapus', 'MasterRule@master_penawaran_rule_hapus')->name('master_penawaran.rule_hapus');
Route::post('/master/penawaran/rule/hapus_semua', 'MasterRule@master_penawaran_rule_hapus_semua')->name('master_penawaran.rule_hapus_semua');
Route::post('/submit', 'AllPageController@submit');
Route::post('/po/submit', 'AllPageController@submit_po');
Route::get('/master/paragraf', 'AllPageController@paragraf');
Route::get('/preview/{kode}', 'AllPageController@preview');
Route::get('/print/{kode}', 'AllPageController@print');
Route::get('/preview/po/{kode}', 'AllPageController@po_preview');
Route::get('/print/po/{kode}', 'AllPageController@po_print');
Route::get('/master/penawaran/pelanggan', 'AllPageController@perusahaan_pelanggan');
Route::post('/master/penawaran/pelanggan/fetch', 'AutocompleteController@fetch')->name('autocomplete.fetch');
Route::post('/master/penawaran/pelanggan/fetch_edit', 'AutocompleteController@fetch_edit')->name('autocomplete.fetch_edit');
Route::post('/master/penawaran/pelanggan/tambah', 'AllPageController@perusahaan_pelanggan_tambah');
Route::post('/master/penawaran/pelanggan/edit', 'AllPageController@perusahaan_pelanggan_edit');
Route::get('/master/penawaran/pelanggan/hapus', 'AllPageController@perusahaan_pelanggan_hapus');
Route::get('/master/penawaran/pelanggan/view/{kode}', 'AllPageController@perusahaan_pelanggan_view');
Route::get('/master/po/paragraf','AllPageController@paragraf_po');
Route::post('/master/po/paragraf/edit','AllPageController@paragraf_po_edit');
Route::get('/master/kode','AllPageController@kode_po');
Route::get('/master/kode/view/{kode}','AllPageController@kode_po_view');
Route::post('/master/kode/tambah','AllPageController@kode_po_tambah');
Route::post('/master/kode/edit','AllPageController@kode_po_edit');
Route::post('/master/kode/hapus','AllPageController@kode_po_hapus');
Route::get('/master/po/supplier','AllPageController@supplier');
Route::get('/master/po/supplier/view/{kode}','AllPageController@supplier_view');
Route::post('/master/po/supplier/tambah','AllPageController@supplier_tambah');
Route::post('/master/po/supplier/edit','AllPageController@supplier_edit');
Route::post('/master/po/supplier/hapus','AllPageController@supplier_hapus');
Route::post('/master/po/supplier/vendor_fetch', 'AutocompleteController@vendor_fetch')->name('vendor.fetch');
Route::post('/master/po/supplier/vendor_fetch_edit', 'AutocompleteController@vendor_fetch_edit')->name('vendor.fetch_edit');
Route::get('/list/penawaran','AllPageController@list_penawaran');
Route::get('/list/penawaran/edit/{kode}','AllPageController@list_penawaran_edit');
Route::get('/list/penawaran/edit/{kode}/view-memo/','AllPageController@list_penawaran_memo_view')->name('list_penawaran.memo_view');
Route::post('/list/penawaran/edit/{kode}/view-memo/submit','AllPageController@list_penawaran_memo_submit')->name('list_penawaran.memo_submit');
Route::post('/list/penawaran/edit/{kode}/submit','AllPageController@list_penawaran_submit');
Route::post('/list/penawaran/edit/{kode}/barang/tambah','AllPageController@list_penawaran_tambah_barang');
Route::post('/list/penawaran/edit/{kode}/barang/edit','AllPageController@list_penawaran_edit_barang');
Route::post('/list/penawaran/edit/{kode}/barang/hapus','AllPageController@list_penawaran_hapus_barang');
Route::post('/list/penawaran/delete','AllPageController@list_penawaran_delete');
Route::get('/list/po','AllPageController@list_po');
Route::post('/list/po/delete','AllPageController@list_po_delete');
Route::get('/list/po/edit/{kode}','AllPageController@list_po_edit');
Route::get('/list/po/edit/{kode}/memo-view','AllPageController@list_po_memo_view')->name('list_po.memo_view');
Route::post('/list/po/edit/{kode}/memo-view/submit','AllPageController@list_po_memo_submit')->name('list_po.memo_submit');
Route::post('/list/po/edit/{kode}/barang/tambah','AllPageController@list_po_tambah_barang');
Route::post('/list/po/edit/{kode}/barang/edit','AllPageController@list_po_edit_barang');
Route::post('/list/po/edit/{kode}/barang/hapus','AllPageController@list_po_hapus_barang');
Route::post('/list/po/edit/{kode}/submit','AllPageController@list_po_submit');
Route::get('/list/buku-ekspedisi','AllPageController@list_buku_ekspedisi');
Route::get('/list/buku-ekspedisi/edit/{id}','AllPageController@list_buku_ekspedisi_edit');
Route::get('/list/buku-ekspedisi/edit/{id}/memo-view','AllPageController@list_buku_ekspedisi_memo_view')->name('buku_ekspedisi.memo_view');
Route::post('/list/buku-ekspedisi/edit/{id}/memo-view/submit','AllPageController@list_buku_ekspedisi_memo_submit')->name('buku_ekspedisi.memo_submit');
Route::post('/list/buku-ekspedisi/edit/{id}/submit','AllPageController@list_buku_ekspedisi_submit')->name('list_buku_ekspedisi.submit');
Route::post('/list/buku-ekspedisi/edit/{id}/gambar/edit','AllPageController@buku_ekspedisi_edit_gambar')->name('buku_ekspedisi.edit_gambar');
Route::post('/list/buku-ekspedisi/edit/{id}/gambar/tambah','AllPageController@buku_ekspedisi_tambah_gambar')->name('buku_ekspedisi.tambah_gambar');
Route::post('/list/buku-ekspedisi/edit/{id}/gambar/hapus','AllPageController@buku_ekspedisi_hapus_gambar')->name('buku_ekspedisi.hapus_gambar');
Route::post('/list/buku-ekspedisi/hapus','AllPageController@list_buku_ekspedisi_hapus')->name('buku_ekspedisi.hapus');
Route::get('/master/perusahaan','AllPageController@po_perusahaan');
Route::get('/master/perusahaan/view/{kode}','AllPageController@po_perusahaan_view');
Route::post('/master/perusahaan/fetch','AutocompleteController@perusahaan_fetch')->name('perusahaan.fetch');
Route::post('/master/perusahaan/fetch-edit','AutocompleteController@perusahaan_fetch_edit')->name('perusahaan.fetch_edit');
Route::post('/master/perusahaan/tambah','AllPageController@po_perusahaan_tambah');
Route::post('/master/perusahaan/hapus','AllPageController@po_perusahaan_hapus');
Route::post('/master/perusahaan/edit','AllPageController@po_perusahaan_edit');
Route::get('/master/ekspedisi','AllPageController@ekspedisi');
Route::get('/master/ekspedisi/{id}/memo','AllPageController@ekspedisi_memo')->name('master_ekspedisi.memo');
Route::post('/master/ekspedisi/{id}/memo/submit','AllPageController@ekspedisi_memo_submit')->name('master_ekspedisi.memo_submit');
Route::post('/master/ekspedisi/tambah','AllPageController@ekspedisi_tambah');
Route::post('/master/ekspedisi/edit','AllPageController@ekspedisi_edit');
Route::post('/master/ekspedisi/hapus','AllPageController@ekspedisi_hapus');
Route::get('/buku-ekspedisi','AllPageController@buku_ekspedisi');
Route::post('/buku-ekspedisi/submit','AllPageController@buku_ekspedisi_submit');
Route::get('/master/sekolah',"POSekolahController@master_sekolah");
Route::get('/master/sekolah/memo/{id}',"POSekolahController@master_sekolah_memo")->name('master_sekolah.memo');
Route::post('/master/sekolah/memo/{id}/edit',"POSekolahController@master_sekolah_memo_edit")->name('master_sekolah.memo_edit');
Route::get('/master/sekolah/view/{kode}',"POSekolahController@master_sekolah_view")->name('sekolah.view');
Route::post('/master/sekolah/tambah',"POSekolahController@master_sekolah_tambah")->name('sekolah.tambah');
Route::post('/master/sekolah/edit',"POSekolahController@master_sekolah_edit")->name('sekolah.edit');
Route::post('/master/sekolah/hapus',"POSekolahController@master_sekolah_hapus")->name('sekolah.hapus');
Route::get('/po-sekolah',"POSekolahController@po_sekolah");
Route::post('/po-sekolah/id_sekolah',"POSekolahController@po_sekolah_id")->name('po_sekolah.id');
Route::post('/po-sekolah/submit',"POSekolahController@po_sekolah_submit")->name('po_sekolah.submit');
Route::get('/preview/po-sekolah/{kode}',"POSekolahController@po_sekolah_preview")->name('po_sekolah.preview');
Route::get('/print/po-sekolah/{kode}',"POSekolahController@po_sekolah_print")->name('po_sekolah.preview');
Route::get('/list/po-sekolah',"POSekolahController@list_po_sekolah")->name('po_sekolah.list');
Route::get('/list/po-sekolah/edit/{kode}',"POSekolahController@list_po_sekolah_edit");
Route::post('/list/po-sekolah/edit/{kode}/submit',"POSekolahController@list_po_sekolah_edit_submit")->name('po_sekolah.edit_submit');
Route::get('/list/po-sekolah/edit/{kode}/memo-view',"POSekolahController@list_po_sekolah_memo_view")->name('po_sekolah.memo_view');
Route::post('/list/po-sekolah/edit/{kode}/memo-view/submit',"POSekolahController@list_po_sekolah_memo_submit")->name('po_sekolah.memo_submit');
Route::post('/list/po-sekolah/edit/{kode}/barang/edit',"POSekolahController@list_po_sekolah_edit_barang")->name('po_sekolah.edit_barang');
Route::post('/list/po-sekolah/edit/{kode}/barang/hapus',"POSekolahController@list_po_sekolah_hapus_barang")->name('po_sekolah.hapus_barang');
Route::post('/list/po-sekolah/edit/{kode}/barang/tambah',"POSekolahController@list_po_sekolah_tambah_barang")->name('po_sekolah.tambah_barang');
Route::post('/list/po-sekolah/hapus',"POSekolahController@list_po_sekolah_hapus")->name('po_sekolah.hapus');
Route::get('/tanda-terima-barang',"TandaTerimaController@index")->name('tanda');
Route::get('/master/paragraf/ttb',"TandaTerimaController@paragraf")->name('paragraf_ttb');
Route::post('/master/paragraf/ttb/edit',"TandaTerimaController@paragraf_edit")->name('paragraf_ttb.edit');
Route::post('/tanda-terima-barang/submit',"TandaTerimaController@tanda_terima_barang_tambah")->name('tanda.submit');
Route::get('/preview/tanda-terima-barang/{no_po}',"TandaTerimaController@tanda_terima_barang_preview");
Route::get('/print/tanda-terima-barang/{no_po}',"TandaTerimaController@tanda_terima_barang_print");
Route::get('/list/tanda-terima-barang',"TandaTerimaController@list_ttb");
Route::post('/list/tanda-terima-barang/hapus',"TandaTerimaController@list_ttb_hapus")->name('list_ttb.hapus');
Route::get('/list/tanda-terima-barang/edit/{no_do}',"TandaTerimaController@list_ttb_edit");
Route::get('/list/tanda-terima-barang/edit/{no_do}/memo-view',"TandaTerimaController@list_ttb_memo_view")->name('list_ttb.memo_view');
Route::post('/list/tanda-terima-barang/edit/{no_do}/memo-view/submit',"TandaTerimaController@list_ttb_memo_submit")->name('list_ttb.memo_submit');
Route::post('/list/tanda-terima-barang/edit/{no_do}/submit',"TandaTerimaController@list_ttb_edit_submit")->name('tanda.edit');
Route::post('/list/tanda-terima-barang/edit/{no_do}/tambah-gambar',"TandaTerimaController@list_ttb_tambah_gambar")->name('tanda.tambah_gambar');
Route::post('/list/tanda-terima-barang/edit/{no_do}/edit-gambar',"TandaTerimaController@list_ttb_edit_gambar")->name('tanda.edit_gambar');
Route::post('/list/tanda-terima-barang/edit/{no_do}/hapus-gambar',"TandaTerimaController@list_ttb_hapus_gambar")->name('tanda.hapus_gambar');
Route::post('/list/tanda-terima-barang/edit/{no_do}/tambah-barang',"TandaTerimaController@list_ttb_tambah_barang")->name('tanda.tambah_barang');
Route::post('/list/tanda-terima-barang/edit/{no_do}/edit-barang',"TandaTerimaController@list_ttb_edit_barang")->name('tanda.edit_barang');
Route::post('/list/tanda-terima-barang/edit/{no_do}/hapus-barang',"TandaTerimaController@list_ttb_hapus_barang")->name('tanda.hapus_barang');
Route::post('/list/tanda-terima-barang/filter',"TandaTerimaController@list_ttb_search")->name('filter.tanda');
Route::post('/table/filter/ttb',"TandaTerimaController@list_ttb_search")->name('table.ttb');
Route::post('/list/penawaran/filter',"FilterPenawaranController@list_penawaran_search")->name('filter.penawaran');
Route::post('/list/po/filter',"FilterPOController@list_po_search")->name('filter.po');
Route::post('/list/po-sekolah/filter',"FilterPOSekolahController@list_po_sekolah_search")->name('filter.po_sekolah');
Route::post('/list/buku-ekspedisi/filter',"FilterBukuEkspedisiController@list_buku_ekspedisi_search")->name('filter.buku_ekspedisi');
Route::get('/master/bank','MasterBankController@index')->name('master_bank.index');
Route::post('/master/bank/tambah','MasterBankController@tambah')->name('master_bank.tambah');
Route::post('/master/bank/edit','MasterBankController@edit')->name('master_bank.edit');
Route::post('/master/bank/hapus','MasterBankController@hapus')->name('master_bank.hapus');
Route::get('/master/delete-data','MasterDeleteData@index')->name('master_delete_data.index');
Route::get('/helpdesk','HelpDeskController@index')->name('helpdesk');
Route::post('/helpdesk/input','HelpDeskController@input')->name('helpdesk.input');
Route::get('/list/helpdesk','HelpDeskController@list_helpdesk')->name('list.helpdesk');


