/* eslint-disable no-undef */
describe("Artisan's directory page", function() {
  it("should be able to open artisan's directory page", function() {
    cy.visit('/annuaire-des-artisans')

    cy.contains('Construction').should('exist')
    cy.contains('Canalisation').should('not.be.visible')

    cy.contains('Construction').click()
    cy.contains('Canalisation').should('be.visible')
  })
})
