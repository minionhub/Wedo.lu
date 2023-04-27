describe('my account page', function() {
  beforeEach(() => {
    cy.fixture('users/johndoe').as('john')
  })

  it('should be able to login', function() {
    cy.viewport(1920, 951)

    cy.visit('/my-account')

    cy.contains('Connectez-vous').should('exist')

    cy.get('form[data-vv-scope="login"] input[name="login.email"]')
      .type(this.john.email)
      .should('have.value', this.john.email)

    cy.get('form[data-vv-scope="login"] input[name="login.password"]')
      .type(this.john.password)
      .should('have.value', this.john.password)

    cy.get('form[data-vv-scope="login"] button')
      .contains('Connexion')
      .click()

    cy.contains('Connectez-vous').should('not.exist')

    cy.contains('Bienvenue ' + this.john.name).should('be.visible')

    cy.location('pathname').should('eq', '/dashboard')
  })
})
