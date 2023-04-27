/* eslint-disable no-undef */
describe("user's dashboard page", function() {
  beforeEach(() => {
    // eslint-disable-next-line no-undef
    cy.fixture('users/johndoe').as('john')
  })

  it("should show user's details", function() {
    cy.visit('/my-account')

    cy.contains('Connectez-vous').should('exist')

    cy.get('input[name="login.email"]').type(this.john.email)

    cy.get('input[name="login.password"]').type(this.john.password)

    cy.get('button')
      .contains('Connexion')
      .click()
    cy.get('.hover-panel')
      .contains('Changer mot de passe')
      .click()

    cy.get('input[id="first-name"]').should('have.value', this.john.first_name)
    cy.get('input[id="last-name"]').should('have.value', this.john.last_name)
    cy.get('input[id="email"]').should('have.value', this.john.email)
  })
})
