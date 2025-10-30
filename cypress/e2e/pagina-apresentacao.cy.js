describe('Teste página de apresentação', () => {
  
  beforeEach(() => {
      cy.visit('/PaginaApresentacao.php');
  });

  it("Testando botão Começar Agora", () => {
    cy.get('.comecar').click();
    // cy.visit("pagina-cadastro.php");
  })

  it("Testando botão Matricule-se", () => {
    cy.get(".Matricular").click();
    // cy.visit("pagina-cadastro.php");
  })

  it("Testando botão Quero Fazer Parte", () => {
    cy.get(".fzrparte").click();
    // cy.visit("pagina-cadastro.php");
  })

  it("Enviando uma mensagem na aba “Fale Conosco”", ()  => {
    cy.get(".mensagem").type("Site maravilhoso, me ajudou muito!");
    cy.get(".email").type("usuario123@gmail.com");
    cy.get(".nome").type("Usuário Falante");
    cy.get("#envio").click();
    
  })

  it("Tentando enviar Feedback com campos vazios", () => {
    cy.get("#envio").click();
  })
})