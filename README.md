# Sistema basico de gerenciamento de produtos | categorias

O sistema foi criado com arquitetura MVC, composer para gerenciar dependências, para gerenciar rotas foi utilizado bramus router,
foi adicionado a cdn bootstrap | font awesome | sweet alert | javascript para o front-end, no back-end foi utilizado PHP puro orientado a objetos
com banco de dados mysql (PDO e transactions).

- Clone o repositorio
```
git clone https://herlandio7@bitbucket.org/herlandio7/webjump-teste.git
```
- Instale as dependências
```
composer install
```

- Crie um banco de dados chamado `products`.
```
CREATE DATABASE products;
```
```
USE products;
```
- Crie duas tabelas: `products` | `categories`
```
CREATE TABLE `products` (
  `productID` int NOT NULL AUTO_INCREMENT,
  `productName` varchar(255) NOT NULL,
  `productSku` varchar(255) NOT NULL,
  `productPrice` float NOT NULL,
  `productDescription` text NOT NULL,
  `productQuantity` int NOT NULL,
  `productCategoryOne` varchar(50) DEFAULT NULL,
  `productCategoryTwo` varchar(50) DEFAULT NULL,
  `productCategoryThree` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`productID`)
);

CREATE TABLE `categories` (
  `categoryID` int NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(50) NOT NULL,
  PRIMARY KEY (`categoryID`)
);
```

- Para configurar as credencias do banco de dados acesse a pasta `config` e edit as constantes.

- Para executar acesse a pasta `webjump`:
```
php -S localhost:8000
```
