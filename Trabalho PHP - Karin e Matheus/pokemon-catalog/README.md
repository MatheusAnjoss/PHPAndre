# Pokémon Catalog

Este projeto é um catálogo de Pokémon, semelhante a um Pokédex, que permite aos usuários visualizar, adicionar e filtrar Pokémon. O sistema é construído em PHP e utiliza uma estrutura MVC (Modelo-Visão-Controlador) para organizar o código.

## Estrutura do Projeto

```
pokemon-catalog
├── public
│   ├── index.php          # Ponto de entrada da aplicação
│   ├── css
│   │   └── styles.css     # Estilos da aplicação
│   └── js
│       └── scripts.js     # Funcionalidade JavaScript do lado do cliente
├── src
│   ├── controllers
│   │   ├── PokemonController.php  # Controlador para gerenciar Pokémon
│   │   └── FilterController.php    # Controlador para filtrar Pokémon
│   ├── models
│   │   └── Pokemon.php             # Modelo que representa os dados do Pokémon
│   ├── views
│   │   ├── home.php                # Página inicial com lista de Pokémon
│   │   ├── pokemon.php             # Página de detalhes de um Pokémon específico
│   │   └── filter.php              # Página de filtro para buscar Pokémon
│   └── utils
│       └── database.php            # Funções para conexão com o banco de dados
├── .env                            # Variáveis de ambiente para configuração
├── composer.json                   # Configuração do Composer
└── README.md                       # Documentação do projeto
```

## Instalação

1. Clone o repositório:
   ```
   git clone <URL do repositório>
   ```

2. Navegue até o diretório do projeto:
   ```
   cd pokemon-catalog
   ```

3. Instale as dependências usando o Composer:
   ```
   composer install
   ```

4. Configure o arquivo `.env` com as informações do banco de dados.

5. Inicie o servidor local:
   ```
   php -S localhost:8000 -t public
   ```

## Uso

- Acesse `http://localhost:8000` para visualizar a lista de Pokémon.
- Utilize a página de filtro para buscar Pokémon com base em critérios específicos.
- Clique em um Pokémon para ver detalhes sobre suas características e habilidades.

## Contribuição

Contribuições são bem-vindas! Sinta-se à vontade para abrir um problema ou enviar um pull request.