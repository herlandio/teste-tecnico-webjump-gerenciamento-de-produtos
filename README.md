[![cicd](https://github.com/herlandio/teste-tecnico-webjump-gerenciamento-de-produtos/actions/workflows/cicd.yml/badge.svg)](https://github.com/herlandio/teste-tecnico-webjump-gerenciamento-de-produtos/actions/workflows/cicd.yml)

# [Teste Técnico WebJump] Gerenciamento de Produtos e Categorias

Este sistema foi desenvolvido utilizando a arquitetura MVC, com Composer para gerenciar as dependências. Para o gerenciamento de rotas, foi utilizado o Bramus Router. O front-end incorpora a CDN do Bootstrap, Font Awesome, SweetAlert e JavaScript. No back-end, foi utilizado PHP puro orientado a objetos, com um banco de dados MySQL, utilizando PDO e transações.

Observação: O teste não solicitou o uso de Kubernetes (K8s) ou Docker.

Como Executar o Projeto
1. Clone o Repositório:

    ```
    git clone https://github.com/herlandio/gerenciamento-de-produtos.git
    ```
2. Crie o ConfigMap, 
    
    Substitua "user" pelo seu nome de usuário no comando abaixo:

    ```
    kubectl create configmap kube-config --from-file=config=/home/<user>/.kube/config
    ```

3. Suba a Aplicação:
    ```
    kubectl apply -f k8s/
    ```

4. Requisitos:
    - Certifique-se de ter o Docker e o Kubernetes habilitados em sua máquina.

5. Acesse a Aplicação: 
    
    Abra seu navegador e vá para: 
    ```
    http://localhost
    ```
## Testes

Para executar os testes, obtenha o nome do pod com o comando:

```
kubectl get pods
```

Em seguida, execute os testes no pod:
 
```
 kubectl exec <nomedopod> -- vendor/bin/phpunit tests
```

### Para Usar com Docker Compose

```
docker-compose up -d
```

## Testes via Docker

Para executar os testes usando Docker, utilize o comando:

```
docker exec teste-tecnico-webjump-gerenciamento-de-produtos-web-1 vendor/bin/phpunit tests
```
