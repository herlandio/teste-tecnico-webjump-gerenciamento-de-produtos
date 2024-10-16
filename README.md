[![cicd](https://github.com/herlandio/teste-tecnico-webjump-gerenciamento-de-produtos/actions/workflows/cicd.yml/badge.svg)](https://github.com/herlandio/teste-tecnico-webjump-gerenciamento-de-produtos/actions/workflows/cicd.yml)

# [Teste Técnico WebJump] Gerenciamento de Produtos e Categorias

Este sistema foi desenvolvido utilizando a arquitetura MVC, com Composer para gerenciar as dependências. Para o gerenciamento de rotas, foi utilizado o Bramus Router. O front-end incorpora a CDN do Bootstrap, Font Awesome, SweetAlert e JavaScript. No back-end, foi utilizado PHP puro orientado a objetos, com um banco de dados MySQL, utilizando PDO e transações.

Observação: O teste não solicitou o uso de Kubernetes (K8s) ou Docker.

Como Executar o Projeto
1. Clone o Repositório:

    ```
    git clone https://github.com/herlandio/gerenciamento-de-produtos.git
    ```
2. Suba a Aplicação:
    ```
    kubectl apply -f k8s/
    ```
3. Requisitos:
    - Certifique-se de ter o Docker e o Kubernetes habilitados em sua máquina.

4. Acesse a Aplicação: Abra seu navegador e vá para: 
    ```
    http://localhost
    ```

