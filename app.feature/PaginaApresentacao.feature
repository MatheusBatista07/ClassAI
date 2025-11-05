Feature: Navigation and viewing of the presentation page.

Scenario: Click on the 'Começar Agora' button
Given I am on the presentation page
When I click on the "Começar Agora" button
Then I am redirected to the registration page

Scenario: Click on the 'Matricule-se' button
Given I am on the presentation page
When I click on the "Matricule-se" button
Then I am redirected to the registration page

Scenario: Click on the 'Fazer Parte' button
Given I am on the presentation page
When I click on the "Quero Fazer Parte" button
Then I am redirected to the registration page

Scenario: Send a message through 'Fale Conosco'
Given I am on the presentation page
When I click on the message field and type "Wonderful site, it helped me a lot!"
And I click on the email field and type "usuario123@gmail.com"
And I click on the name field and type "Talkative User"
And I click on the "Enviar" button
Then my feedback is sent
And the message "Mensagem enviada com sucesso" appears

Scenario: Trying to send a message through 'Fale Conosco' with empty fields
Given I am on the presentation page
And the message field is empty
And the email field is empty
And the name field is empty
And I click on the "Enviar" button
Then the message "Preencha todos os campos!" appears