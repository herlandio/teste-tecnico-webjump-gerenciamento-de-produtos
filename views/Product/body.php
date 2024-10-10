<div class="container-fluid">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8 py-5 bg-primary rounded-top">
            <h1 class="text-center text-light">Crie um produto</h1>
        </div>
    </div>
    <div class="row justify-content-center mb-5">
        <div class="col-md-8 py-5 px-5 bg-light rounded-bottom">

            <a href="/" class="mb-5 btn btn-transparent">
                    <span style="font-size: 1em; color: #007bff;">
                        <i class="fa-solid fa-arrow-left fa-2xl"></i>
                    </span>
            </a>

            <form action="/products/save" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Produto</label>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="name">
                </div>
                <div class="form-group">
                    <label for="sku">SKU</label>
                    <input type="text" class="form-control" id="sku" name="sku" aria-describedby="sku">
                </div>
                <div class="form-group">
                    <label for="price">Preço</label>
                    <input class="form-control" type="number" step="any" id="price" name="price" aria-describedby="price">
                </div>
                <div class="form-group">
                    <label for="description">Descrição</label>
                    <input type="text" class="form-control" id="description" name="description" aria-describedby="description">
                </div>
                <div class="form-group">
                    <label for="quantity">Quantidade</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" aria-describedby="quantity">
                </div>

                <div class="form-group">
                    <label for="category">Categorias</label>

                    <select class="custom-select form-control" id="category" multiple name="category[]" aria-label="multiple category">
                        <option value="" selected>Selecione uma categoria</option>

                        <?php

                        foreach ((new \Controllers\CategoriesController())->listCategories() as $category) {
                            echo "<option value=\"{$category['categoryName']}\">{$category['categoryName']}</option>";
                        }
                        ?>

                    </select>

                </div>
                <p class="text-muted">Para selecionar mais de uma categoria segure a tecla CTRL, no máximo 3 opções</p>
                <input type="submit" class="btn btn-primary" id="saveProducts" value="Cadastrar">
            </form>

        </div>
    </div>
</div>
