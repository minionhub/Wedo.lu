/* eslint-disable no-undef */
describe('user details page', function() {
  beforeEach(() => {
    cy.fixture('users/johndoe').as('john')
  })

  it("should change user's password", function() {
    cy.visit('/my-account')

    cy.contains('Connectez-vous').should('exist')

    cy.get('input[name="login.email"]').type(this.john.email)

    cy.get('input[name="login.password"]').type(this.john.password)

    cy.get('button')
      .contains('Connexion')
      .click()

    cy.contains('Connectez-vous').should('not.exist')
    cy.contains('Bienvenue ' + this.john.name).should('be.visible')
    cy.location('pathname').should('eq', '/dashboard')

    cy.get('.hover-panel')
      .contains('Changer mot de passe')
      .click()

    cy.get('input[name="Current password"]').type(this.john.wrongPassword)
    cy.get('input[name="New password"]').type(this.john.newPassword)
    cy.get('input[name="Confirm new password"]').type(this.john.newPassword)

    cy.get('button')
      .contains('Enregistrer les modifications')
      .click()

    cy.contains('Veillez saisir votre mot de passe actuel valide.').should(
      'be.visible'
    )

    cy.get('input[name="Current password"]')
      .clear()
      .type(this.john.password)

    cy.get('input[name="New password"]')
      .clear()
      .type(this.john.newPassword)

    cy.get('input[name="Confirm new password"]')
      .clear()
      .type(this.john.newPassword)

    cy.get('button')
      .contains('Enregistrer les modifications')
      .click()

    cy.contains('Les détails du compte ont bien été modifiés.').should(
      'be.visible'
    )

    cy.get('input[name="Current password"]')
      .clear()
      .type(this.john.newPassword)

    cy.get('input[name="New password"]')
      .clear()
      .type(this.john.password)

    cy.get('input[name="Confirm new password"]')
      .clear()
      .type(this.john.password)

    cy.get('button')
      .contains('Enregistrer les modifications')
      .click()

    cy.contains('Les détails du compte ont bien été modifiés.').should(
      'be.visible'
    )
  })
})
