<link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="https:/netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="https:/code.jquery.com/jquery-1.11.1.min.js"></script>
<script>
$(function () {
    $('#dinamis .add-row').click(function () {
        var template = '<tr><td><input class="form-control" type="text"></td><td><input class="form-control" type="text"></td><td><input class="form-control" type="text"></td><td><input class="form-control harga" type="number"></td><td><button type="button" class="btn btn-danger delete-row">-</button></td></tr>';
        $('#dinamis tbody').append(template);
    });

    $('#dinamis').on('click', '.delete-row', function () {
        $(this).parent().parent().remove();
    });
    $('.harga').blur(function(){
        var sum = 0;
        $('.harga').each(function(){
          sum += parseInt(this.value);
        });
        console.log(sum);
    });
})
</script>
<div class="container">
	<div class="row">
		<h2>Dinamis Form</h2>
	</div>
    <div class="row">
        <h3 class="text-center text-primary">Membuat Dinamis Form Jurnalcode</h3>
        <div class="col-md-12">
            <table class="table table-hover" id="dinamis">
                <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Alamat</th>
                        <th>Kelas</th>
                        <th>Telephone</th>
                        <th>
                            <button type="button" class="btn btn-blue add-row">+</button></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input class="form-control" type="text"></td>
                        <td>
                            <input class="form-control" type="text"></td>
                        <td>
                            <input class="form-control" type="text"></td>
                        <td>
                            <input class="form-control harga" type="number"></td>
                        <td>
                            <button type="button" class="btn btn-danger delete-row">-</button></td>
                    </tr>
                </tbody>
            </table>
            <input type="number" name="total" id="total" class="jumlah">
        </div>
    </div>
</div>