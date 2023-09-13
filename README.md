# Instalação
Após clonar o projeto, instale as dependência utilizando o composer:
```
composer install
```

# Configurando o ambiente
Após instaladas as dependências, deve-se criar um novo arquivo `.env`  copiando o arquivo `.env.example`:
```
cp .env.example .env
```
No contexto dessa aplição, o arquivo `.env`  será apenas para silenciar alguns warnings.

## Docker e Laravel Sail
O [Laravel Sail](https://github.com/laravel/sail) foi utilizado para criar os containers utilizados pela aplicação.
Podemos usar o Sail para rodar comandos Artisan dentro do container da aplicação:
```
./vendor/bin/sail artisan app:message-of-the-day
```
Pode-se criar um alias para agilizar o uso do sail:
```
alias sail="bash ./vendor/bin/sail"
```

Os comandos mostrados neste documento utilizarão o sail no lugar de utilizar o `docker-compose` diretamente.

# Iniciando a aplicação
A aplicação pode ser iniciada pelo `sail` utilizando o seguinte comando:
```
sail up
ou
sail up -d
```

Com isso o serviço `laravel.test`, que corresponde ao container principal da aplicação será iniciado.
A primeira execução desse comando pode demorar um pouco já que o docker precisará construir os containers. Caso o processo de build falhe,
tente executar o comando novamente no caso do build ter falhado por causa de algum erro de rede.

## Executando `sail` como usuário root com `sudo`
Se o seu usuário não possuir permissões para executar o docker sem o `sudo`, a execução de comandos com o sail como root pode causar problemas
com o container da aplicação relacionados a permissão de pastas. Neste caso, deve-se sobrescrever as variáveis `WWWUSER` e `WWWGROUP` no arquivo
`.env` da seguinte maneira:
```
WWWUSER=1000 #execute 'echo $UID' para obter o id do seu usuário
WWWGROUP=1000 #execute 'id -g' para obter o id do grupo do seu usuário
```

Após isso execute o processo de build dos containers novamente:
```
sudo ./vendor/bin/sail build
```
Com isso a aplicação agora deve funcionar sem os problemas mencionados anteriormente.

# Executando o comando principal da aplicação
Para esse teste foi feito uma aplicação que exibe uma mensagem diferente para cada dia da semana, tratando também algumas datas especiais como o Natal.
Para executar o código que faz essa tarefa, podemos executar o seguinte comando:
```
php artisan app:message-of-the-day
ou
sail artisan app:message-of-the-day
```
A mensagem do dia será exibida na tela após a execução do comando.
# Testes Automatizados
A suite de testes automatizados podem ser executados usando os seguintes comandos:
```
sail artisan test
ou
sail test
```