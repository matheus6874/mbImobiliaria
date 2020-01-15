# mbimobiliaria
Trabalho para a disciplina de programação para internet

Descrição Geral
Desenvolver um website para uma imobiliária de acordo com as especificações a seguir. O website deve 
ser organizado em duas partes: uma de acesso restrito, voltada para a equipe interna da imobiliária; e 
outra de acesso livre, voltada para o público em geral.
Todas as páginas do website devem possuir um layout contendo quatro partes: um cabeçalho, uma 
barra de navegação, um rodapé e uma parte principal para exibição de conteúdo. Um exemplo de layout
é apresentado em www.w3schools.com/html/html_layout.asp (não é obrigatório o uso deste layout - é 
apenas um exemplo).
Recomenda-se a leitura completa deste documento antes de iniciar o desenvolvimento do website.
Área de Acesso Público
A parte do website voltada para o público em geral deve ter:
1. Uma página principal (Home) para exibição das informações da imobiliária (logotipo, imagem de 
boas vindas, missão, valores, etc). Cada grupo deverá criar um nome fictício para a imobiliária. 
2. Uma página para realização de pesquisa por imóveis. A página deverá possibilitar que o usuário 
realize pesquisas por imóveis de acordo com os seguintes critérios:
a. Propósito do usuário: Aquisição (quando o usuário deseja buscar imóveis com a intenção 
de comprar) ou locação (quando o usuário está interessado em alugar um imóvel);
b. Bairro: campo de seleção para que o usuário possa indicar o bairro em que deseja comprar 
ou alugar o imóvel. Este campo deverá ser carregado automaticamente, utilizando AJAX, 
assim que o usuário selecionar o propósito da busca (aquisição ou locação). O sistema 
deverá exibir na caixa de seleção apenas os nomes de bairros correspondentes a imóveis 
cadastrados no banco de dados na categoria informada.
c. Valor mínimo e máximo: deverá haver campos para que o usuário informe exatamente os 
valores mínimo e máximo de interesse (no caso de aluguel, tais valores indicarão o valor 
mínimo e o valor máximo do aluguel; no caso de aquisição, os valores indicarão o preço 
mínimo e o preço máximo do imóvel desejado);
d. Outras Informações: campo textual para que o usuário acrescente palavras-chave 
relacionadas a outras características do imóvel (como “armários”, “churrasqueira”, etc.). 
Tais palavras deverão ser utilizadas no procedimento de busca juntamente com o campo 
“descrição” do imóvel na tabela do banco de dados. Se todas as palavras fornecidas pelo 
usuário forem encontradas no campo descrição do imóvel (mesmo que seja em ordem 
diferente do informado), então o imóvel correspondente atende a este critério de busca.
O resultado da busca por imóveis deverá ser apresentado ao usuário primeiramente na forma de uma 
lista contendo as informações de maneira resumida. As informações e fotos devem ser apresentadas 
conforme o layout a seguir. 
A partir da lista de resultados, o usuário deverá ter uma opção para visualizar as informações 
detalhadas do imóvel, assim como todas as suas fotos. Na lista de resultados, apenas as três primeiras 
fotos devem ser apresentadas, em tamanho reduzido. As informações detalhadas e as demais fotos 
devem ser apresentadas em uma janela do tipo modal (utilize Bootstrap), sem perder o resultado da 
busca atual. O usuário deverá ter a opção de fechar a janela modal com as informações detalhadas do 
imóvel e continuar navegando pelos demais resultados da busca.
O usuário também deverá ter uma opção, na listagem dos imóveis, de enviar uma mensagem de 
interesse no imóvel para a imobiliária. Um formulário deverá ser exibido, também em janela modal, para 
coletar os dados do usuário (nome completo, e-mail, telefone e descrição da proposta). O sistema deverá 
registrar no banco de dados as informações sobre o interesse do usuário no imóvel.
Área de Acesso Restrito
A parte pública do website deverá exibir um botão Login na barra de navegação (à direita). Quando o 
usuário clicar nesse botão, um pequeno formulário com os campos login e senha deverá ser apresentado 
através de uma janela modal. Caso os valores informados sejam válidos, o website deverá efetuar o login
e abrir, em nova aba, a página principal da parte restrita do sistema. Para fins de simplificação, a 
validação do login e senha pode ser feita através de uma simples consulta na tabela Funcionário
(utilizando os campos login e senha).
A parte restrita do website deverá ter uma barra de navegação diferente daquela desenvolvida para a 
parte pública e deverá possibilitar as seguintes operações:
1. Cadastro de funcionários da imobiliária;
2. Cadastro de clientes (proprietários dos imóveis);
3. Cadastro de imóveis;
4. Listagem dos funcionários cadastrados;
5. Listagem dos clientes cadastrados
6. Listagem dos imóveis cadastrados;
7. Listagem dos interesses dos usuários nos imóveis;
8. Sair
Cadastro de Funcionários A página deverá exibir um formulário para cadastramento dos funcionários da imobiliária. O formulário
deverá se apresentar de maneira organizada e elegante (com layout horizontal, utilizando Bootstrap). O 
formulário deverá exibir campos para armazenar os seguintes dados dos funcionários: nome, telefone, 
CPF, endereço (CEP, logradouro, bairro, cidade), data de ingresso na imobiliária, cargo e salário. Os 
dados devem ser inseridos adequadamente no banco de dados por meio de um script PHP.
A tecnologia AJAX deve ser utilizada para facilitar o preenchimento do endereço. Assim que o usuário 
digitar o último caractere do CEP, os campos logradouro, bairro e cidade devem ser automaticamente 
preenchidos (uma requisição AJAX deve ser feita ao próprio servidor para resgatar tais dados de uma 
tabela do banco de dados). A equipe de desenvolvimento deverá implementar completamente o serviço 
de busca do endereço a partir do CEP, incluindo a parte do servidor. Não é permitido o uso de serviços 
já existentes, como o dos Correios ou qualquer outro. Os alunos deverão criar uma tabela extra no banco 
de dados e inserir nessa tabela pelo menos cinco endereços para viabilizar essa busca com AJAX.
Cadastro de Clientes
O sistema deverá disponibilizar um formulário para realização do cadastro de clientes. Os seguintes 
dados devem ser armazenados para cada cliente: CPF, nome, endereço (CEP, logradouro, bairro, 
cidade), telefone, e-mail, sexo, estado civil e profissão. Os dados devem ser inseridos adequadamente no 
banco de dados por meio de um script PHP. O preenchimento do endereço deverá ser facilitado 
utilizando AJAX (como no caso do cadastro de funcionários).
Cadastro de Imóveis
O sistema deverá disponibilizar um formulário para cadastramento dos imóveis a serem vendidos ou 
alugados pela imobiliária. O sistema deverá considerar dois tipos de imóveis: casa e apartamento. Para 
ambos os tipos devem ser armazenados:
 o código do proprietário,
 o propósito do imóvel (se está disponível para venda ou locação), 
 o valor do imóvel (valor de venda ou o valor do aluguel, dependendo do contexto),  o bairro do imóvel (não é necessário armazenar as demais informações do endereço),
as fotos do imóvel,  o número de quartos,
 o número de suítes
 e uma descrição.
Para os imóveis do tipo casa ainda devem ser armazenados:
 a área do terreno,  se tem piscina ou não.
Para os imóveis do tipo apartamento ainda devem ser armazenados:
 o número do apartamento,  o andar,  e o valor do condomínio.
No formulário de cadastro de imóvel, os campos de formulário específicos de um tipo de imóvel devem 
aparecer automaticamente depois que o usuário selecionar o tipo do imóvel e preencher os campos 
contendo as informações comuns dos dois tipos de imóvel.
O formulário de cadastro de imóvel deverá apresentar uma opção para indicação do proprietário do 
mesmo através de uma caixa de seleção. O sistema deverá exibir os nomes de todos os clientes 
cadastrados anteriormente para que o usuário selecione um nome de cliente para ser o proprietário do 
imóvel. Embora a indicação do proprietário seja feita através da seleção do nome, os vínculos nas tabelas 
devem ser realizados de maneira adequada utilizando chaves primárias e estrangeiras (não se deve 
armazenar o nome do proprietário na tabela de imóveis).
O sistema deverá permitir que o usuário informe até seis fotos para cada imóvel. As fotos devem ser 
armazenadas de maneira adequada no servidor, em subpasta. Apenas o nome do arquivo de imagem
deverá ser armazenado no banco de dados. O sistema deverá gerar um nome de arquivo próprio, 
seguindo um padrão com base no código do imóvel, na data e hora do cadastro e no número da foto 
(OBS: os integrantes do grupo devem pesquisar sobre o envio de arquivos em formulário e o 
processamento dos mesmos com PHP. Durante a apresentação, os integrantes poderão ser questionados 
sobre qualquer parte do código fonte e precisarão dar explicações detalhadas sobre todas as funções e 
recursos utilizados).
Os dados dos imóveis devem ser armazenados de maneira adequada utilizando o conceito de 
generalização/especialização. Os dados comuns de casas e apartamentos devem ser armazenados em 
uma tabela Imovel e os dados específicos de casas e apartamentos devem ser armazenados em tabelas 
especificas, de nomes ImovelCasa e ImovelApto, com as devidas chaves estrangeiras conectando com a
tabela Imovel.
Listagem das Entidades Cadastradas
O sistema deverá fornecer opções para que o usuário possa listar os funcionários cadastrados, os 
clientes, os imóveis e os interesses dos usuários nos imóveis.
Recursos e Tecnologias
O website deve ser desenvolvido utilizando as seguintes tecnologias: HTML5, CSS, JavaScript, JSON, 
jQuery, Bootstrap, AJAX, PHP e MySQL.
Hospedagem
O website deve ser hospedado gratuitamente nos servidores do awardspace (www.awardsapace.com)
conforme apresentado nos slides de aula. Cada grupo deve criar uma conta no awardsapace.com e utilizá-
la para enviar os arquivos do website, criar e manipular o banco de dados.
Observação Importante
Os alunos envolvidos em qualquer tipo de plágio, total ou parcial, seja entre equipes ou de trabalhos 
feitos em semestres anteriores ou de materiais disponíveis na Internet (exceto os materiais de aula 
disponibilizados pelo professor), serão duramente penalizados (art. 196 do Regimento Geral da UFU). 
Todos os alunos envolvidos terão seus trabalhos anulados e receberão nota zero.
Organização dos Arquivos
Os arquivos do website devem ser bem organizados e estruturados. Arquivos de imagem, código 
JavaScript, CSS, etc., devem ser armazenados em pastas próprias. O website deve ser desenvolvido 
visando uma manutenção prática e eficiente.
Criação de Domínio
Cada grupo deverá registrar um domínio comercial para o website desenvolvido. Há domínios a partir 
de R$ 6,99 no site GoDaddy. Após registro do domínio comercial, as devidas configurações devem ser 
feitas (no próprio site de registro de domínio) para que o usuário seja redirecionado para o endereço do 
subdomínio gratuito criado no awardspace.com.
Outras Especificações e Restrições
 O website deve ser responsível, devendo se apresentar de maneira adequada e legível mesmo 
quando acessado a partir de dispositivos móveis;
 Templates e/ou layouts prontos não devem ser utilizados;
 Outros frameworks e tecnologias não devem ser utilizados;
 O website deverá prevenir ataques do tipo cross-site scripting (XSS) e SQL Injection;  Formulários deverão ser devidamente validados no lado cliente e no servidor;
 O conceito de transação deve ser utilizado sempre que possível durante o cadastro dos dados no 
banco de dados. Eventuais falhas em inserções em tabelas não devem deixar os dados inconsistentes;
 O sistema deverá implementar adequadamente o conceito de sessão em PHP para manter o usuário 
logado durante o acesso à parte restrita. O sistema não deverá permitir o acesso à scripts PHP da 
parte restrita sem que o usuário tenha permissão para tal (sem que esteja devidamente logado).
 Os códigos comuns referentes aos cabeçalhos, barras de navegação e rodapés das páginas não devem 
ser explicitamente repetidos para cada página. Há diversas formas de compartilhar esses elementos 
com todas as páginas que os utilizam. Uma delas é utilizando a declaração PHP include. Veja o 
exemplo a seguir:
<!DOCTYPE html>
<html>
<head>
<title></title>
<body>
<?php include "header.php"; ?>
<?php include "navbar.php"; ?>
<div id="conteudoDaPagina">
</div>
<?php include "footer.php"; ?>
</body>
</html>
