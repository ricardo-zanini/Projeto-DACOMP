# ${\color{lightBlue}Projeto \space DACOMP}$

Projeto para a compra e venda de produtos fornecidos pelo DACOMP, com pagamento via PIX. Projeto desenvolvido para a disciplina de Engenharia de Software, utilizando Next.js

## ${\color{lightBlue}Inicializando \space o \space projeto}$

- Instale o XAMPP em https://www.apachefriends.org/pt_br/download.html
- Navegue até C:\xampp\htdocs
- Abra um Terminal e copie o repositório: git clone https://github.com/ricardo-zanini/Projeto-DACOMP.git
- Ainda no terminal, instale o gerenciador de pacotes Composer, rodando: composer install
- Abra o Painel do Xampp e inicialize o Apache e o MySQL
  
![image](https://github.com/user-attachments/assets/59706288-63d5-42a0-9e71-e4396f96fc22)

- Abra o seu banco de dados local em http://localhost/phpmyadmin/
- Crie um novo banco de dados chamado "DACOMP", clicando no botão "novo"
  
![image](https://github.com/user-attachments/assets/88ee149b-7bfc-4e67-99e9-d9f592d8512c)

- No banco criado, abra uma tela de edição de queryes, e nele cole e rode os códigos SQL para criação de tabelas disponíveis em "QUERYES.sql" localizado na pasta do projeto
- Volte ao terminal da aplicação, e rode o comando: php artisan serve
- Abra o site em localhost:8000


