<div class="container-fluid">

    <div class="row justify-content-center mt-5">
        <div class="col-md-8 py-5 bg-primary rounded-top">
            <h1 class="text-center text-light">Produtos</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 py-5 px-5 bg-light rounded-bottom shadow">

            <a href="/products/create" class="mb-5 btn btn-primary">
                <span style="font-size: 1em; color: #EEEEEE;">
                    <i class="fa-solid fa-plus fa-1xl"></i> Produto
                </span>
            </a>

            <button class="btn btn btn-success mb-5" data-toggle="modal" data-target="#newCategory">
                <i class="fa-solid fa-plus fa-1xl"></i> Categoria
            </button>

            <!-- start modal categories -->

            <div class="modal fade" id="newCategory" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <form action="/categories/categories" method="post" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="categoryModalLabel">Nova categoria</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="newcategory">Categoria</label>
                                    <input type="text" class="form-control" name='newcategory' id="newcategory" aria-describedby="newcategory">
                                </div>

                                <!-- start table categories-->
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="thead-light text-center">
                                            <tr>
                                                <th scope="col">Categoria</th>
                                                <th scope="col">Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php
                                                foreach ((new \Controllers\CategoriesController())->ListCategories() as $category) {
                                                    echo "
                                                        <tr>
                                                            <th>{$category['categoryName']}</th>
                                                            <th>
                                                                <a href=\"/categories/delete/{$category['categoryID']}\" class=\"btn btn-danger btn-sm\">
                                                                    <i class=\"fa-solid fa-trash\"></i>
                                                                </a>
                                                            </th>
                                                        </tr>
                                                    ";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- end table categories -->

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button type="button" class="btn btn-primary" id="saveCategory">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- end modal categorias -->

            <!-- start table products -->

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">SKU</th>
                            <th scope="col">Preço</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                    <?php

                        foreach ((new \Controllers\ProductsController())->ListProducts() as $item) {
                            echo "
                                <tr>
                                    <th scope=\"row\">{$item['productName']}</th>
                                    <td>{$item['productSku']}</td>
                                    <td>{$item['productPrice']}</td>
                                    <td>{$item['productDescription']}</td>
                                    <td>{$item['productQuantity']}</td>
                                    <td>{$item['productCategoryOne']} <br /> {$item['productCategoryTwo']} <br /> {$item['productCategoryThree']}</td>
                                    <td>
                                        
                                        <button class='btn btn-dark btn-sm' data-toggle=\"modal\" data-target=\"#product{$item['productID']}\">
                                            <i class=\"fa-solid fa-eye\"></i>
                                        </button>
                                        
                                        <a href='/products/delete/{$item["productID"]}' class='btn btn-danger btn-sm'>
                                            <i class=\"fa-solid fa-trash\"></i>
                                        </a>

                                        <!-- start modal products -->

                                        <div class=\"modal fade\" id=\"product{$item['productID']}\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"productModalLabel\" aria-hidden=\"true\">
                                            <div class=\"modal-dialog\" role=\"document\">
                                            <div class=\"modal-content\">
                                                <form action=\"/products/update\" method=\"post\" enctype=\"multipart/form-data\" >
                                                
                                                    <div class=\"modal-header\">
                                                        <h5 class=\"modal-title\" id=\"productModalLabel\">Editar Produto</h5>
                                                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                                          <span aria-hidden=\"true\">&times;</span>
                                                        </button>
                                                    </div>
                                                    
                                                    <div class=\"modal-body text-left\">
                                                        <input type=\"hidden\" name=\"id\" class='id' value=\"{$item['productID']}\">
                                                        <div class=\"form-group\">
                                                            <label for=\"name\">Produto</label>
                                                            <input type=\"text\" class=\"form-control name\" name='name' value='{$item['productName']}' aria-describedby=\"name\">
                                                        </div>
                                                        <div class=\"form-group\">
                                                            <label for=\"sku\">SKU</label>
                                                            <input type=\"text\" class=\"form-control sku\" name='sku' value='{$item['productSku']}' aria-describedby=\"sku\">
                                                        </div>
                                                        <div class=\"form-group\">
                                                            <label for=\"price\">Preço</label>
                                                            <input type=\"text\" class=\"form-control price\" name='price' value='{$item['productPrice']}' aria-describedby=\"price\">
                                                        </div>
                                                        <div class=\"form-group\">
                                                            <label for=\"description\">Descrição</label>
                                                            <input type=\"text\" class=\"form-control description\" name='description' value='{$item['productDescription']}' aria-describedby=\"description\">
                                                        </div>
                                                        <div class=\"form-group\">
                                                            <label for=\"quantity\">Quantidade</label>
                                                            <input type=\"number\" class=\"form-control quantity\" name='quantity' value='{$item['productQuantity']}' aria-describedby=\"quantity\">
                                                        </div>                                                    
                                                    </div>
                                                    
                                                    <div class=\"modal-footer\">
                                                        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Fechar</button>
                                                        <button type=\"button\" class=\"btn btn-primary update\" >Atualizar</button>
                                                    </div>
                                                
                                                </form>
                                            </div>
                                          </div>
                                        </div>

                                        <!-- end modal products -->

                                    </td>
                                </tr>
                            ";
                        }

                    ?>
                    </tbody>
                </table>
            </div>

            <!-- end table products -->

        </div>
    </div>
</div>