<div class="row justify-content-center">
<div class="col-md-7">
<h1 class="h4 mb-4">Liên hệ với chúng tôi</h1>
<form method="POST" action="<?= e(base_url('contact')) ?>">
<?= csrf_field() ?>
<div class="mb-3">
<label class="form-label">Họ tên</label>
<input type="text" name="full_name" class="form-control"
required>
</div>
<div class="mb-3">
<label class="form-label">Email</label>
<input type="email" name="email" class="form-control"
required>
</div>
<div class="mb-3">
<label class="form-label">Nội dung</label>
<textarea name="message" class="form-control" rows="5"
required></textarea>
</div>
<button type="submit" class="btn btn-primary">Gửi liên
hệ</button>
</form>
</div>
</div>