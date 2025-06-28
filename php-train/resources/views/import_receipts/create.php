<div class="create">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <h5>Thông tin đơn hàng nhập</h5>
                <form action="/import_receipts/create" method="POST">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="warehouse">Kho:</label>
                        </div>
                        <div class="col-md-8">
                            <select name="warehouse" id="warehouse" class="form-select form-control">
                                <option value="warehouse_id">-- Chọn kho --</option>
                                <?php foreach ($warehouses as $item): ?>
                                    <option value="<?= $item['name'] ?>"
                                        <?= ($oldInput['warehouse'] ?? '') == $item['name'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($item['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($errors['warehouse'])): ?>
                                <p class='error'><?= implode(', ', $errors['warehouse']) ?></p>
                            <?php endif;  ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="code">Mã Đơn:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="code" id="code" value="<?= $oldInput['code'] ?? '' ?>">
                            <?php if (isset($errors['code'])): ?>
                                <p class='error'><?= implode(', ', $errors['code']) ?></p>
                            <?php endif;  ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="received_at">Thời Gian Tạo Đơn:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="date" class="form-control" name="received_at" id="received_at" value="<?= $oldInput['received_at'] ?? '' ?>">
                            <?php if (isset($errors['received_at'])): ?>
                                <p class='error'><?= implode(', ', $errors['received_at']) ?></p>
                            <?php endif;  ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="note">Ghi Chú:</label>
                        </div>
                        <div class="col-md-8">
                            <textarea name="note" class="form-control" id="note" cols="30" rows="10"><?= $oldInput['note'] ?? '' ?></textarea>
                            <?php if (isset($errors['note'])): ?>
                                <p class='error'><?= implode(', ', $errors['note']) ?></p>
                            <?php endif;  ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="products">Sản Phẩm:</label>
                        </div>
                        <div class="col-md-8">
                            <div class="selected list-group"></div>
                            <input type="hidden" name="products" id="selectedProducts" value="">
                        </div>
                    </div>
                    <button type="submit" class="form-control" style="margin-top: 30px;">Gửi</button>

                    <a class="link" href="/import_receipts">← Quay về danh sách</a>
                </form>
            </div>
            <div class="col-md-7">
                <h5>Thông tin sản phẩm</h5>
                <div class="form-search">
                    <input type="text" name="content_search" id="content_search" value="Lapo">
                </div>

                <div id="result" class="list-group list_product"></div>
            </div>
        </div>
    </div>
</div>

<style>
    .list_product .list-group-item {
        display: flex;
        gap: 10px;
    }
</style>

<script>
    const productSelected = []; // Dùng array thay vì Set
    const selectedContainer = document.querySelector('.selected');
    const selectedProductsInput = document.getElementById('selectedProducts');
    const resultContainer = document.getElementById('result');

    document.getElementById('content_search').addEventListener('keydown', function () {
        const content = document.getElementById('content_search').value;
        if (event.key !== 'Enter' || content == '') return;
        const formData = new FormData();
        formData.append('content', content);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/product/search', true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                const products = response.data || [];
                resultContainer.innerHTML = '';

                products.forEach(product => {
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.id = `product-${product.id}`;
                    checkbox.className = 'product-checkbox';
                    checkbox.name = 'products[]';
                    checkbox.value = product.id;
                    checkbox.setAttribute('data-name', product.name);

                    checkbox.addEventListener('change', function () {
                        const value = this.value
                        const name = this.getAttribute('data-name');

                        if (this.checked) {
                            if (!productSelected.includes(value)) {
                                productSelected.push(value);

                                const item = document.createElement('div');
                                item.className = 'selected-item list-group-item';
                                item.dataset.value = value;
                                item.style.display = 'flex';
                                item.style.alignItems = 'center';

                                const nameSpan = document.createElement('span');
                                nameSpan.innerText = name;
                                nameSpan.style.fontWeight = 'bold';
                                nameSpan.style.fontSize = '14px';
                                nameSpan.style.flexGrow = '1';
                                nameSpan.style.marginLeft = '10px';


                                const closeBtn = document.createElement('span');
                                closeBtn.innerText = ' ❌';
                                closeBtn.style.cursor = 'pointer';
                                closeBtn.style.marginLeft = '5px';
                                closeBtn.style.fontSize = '13px';

                                const numberInput = document.createElement('input');
                                numberInput.type = 'number';
                                numberInput.value = 1; // Mặc định số lượng là 1
                                numberInput.style.width = '100px';
                                numberInput.style.marginLeft = 'auto';
                                numberInput.name = 'quantity[]';

                                closeBtn.addEventListener('click', () => {
                                    // Xóa khỏi array
                                    const index = productSelected.indexOf(value);
                                    if (index !== -1) productSelected.splice(index, 1);

                                    // Cập nhật DOM
                                    item.remove();
                                    selectedProductsInput.value = productSelected.join(', ');

                                    // Bỏ check checkbox
                                    const checkbox = document.querySelector(`.product-checkbox[value="${value}"]`);
                                    if (checkbox) checkbox.checked = false;
                                });

                                item.appendChild(closeBtn);
                                item.appendChild(nameSpan);
                                item.appendChild(numberInput);

                                selectedContainer.appendChild(item);
                            }
                        } else {
                            const index = productSelected.indexOf(value);
                            if (index !== -1) {
                                productSelected.splice(index, 1);
                            }

                            const selectedItem = selectedContainer.querySelector(`.selected-item[data-value="${value}"]`);
                            if (selectedItem) selectedItem.remove();
                        }

                        selectedProductsInput.value = productSelected.join(', ');
                    });

                    const label = document.createElement('label');
                    label.htmlFor = checkbox.id;
                    label.style.display = 'flex';
                    label.style.justifyContent = 'space-between';
                    label.style.alignItems = 'center';
                    label.style.width = '100%';
                    label.style.cursor = 'pointer';
                    label.style.padding = '5px 10px';
                    label.style.gap = '10px';

                    const image = document.createElement('img');
                    image.src = product.image || 'https://muave.newwayjsc.com.vn/static/assets/img/empty.jpg';
                    image.style.width = '56px';
                    image.style.height = '40px';
                    image.style.objectFit = 'cover';
                    image.style.borderRadius = '6px';
                    image.style.background = '#f6f8fb';
                    label.appendChild(image);

                    const name = document.createElement('div');
                    name.innerText = product.name;
                    name.style.fontWeight = 'bold';
                    name.style.fontSize = '1.1em';
                    name.style.width = '200px';
                    label.appendChild(name);

                    const info = document.createElement('div');
                    info.innerText = `Mã: ${product.code}`;
                    info.style.fontSize = '0.9em';
                    info.style.color = '#555';

                    const price = document.createElement('span');
                    const formattedPrice = new Intl.NumberFormat('vi-VN', {
                        style: 'currency',
                        currency: 'VND'
                    }).format(product.price);
                    price.innerText = `Giá: ${formattedPrice}`;

                    const divPrice = document.createElement('div');
                    divPrice.style.marginLeft = 'auto';
                    divPrice.appendChild(price);
                    divPrice.appendChild(info);
                    label.appendChild(divPrice);

                    const wrapper = document.createElement('div');
                    wrapper.className = 'list-group-item';
                    wrapper.appendChild(checkbox);
                    wrapper.appendChild(label);

                    resultContainer.appendChild(wrapper);
                });
            } else {
                resultContainer.innerText = 'Lỗi khi gọi AJAX';
            }
        };

        xhr.send(formData);
    });
</script>