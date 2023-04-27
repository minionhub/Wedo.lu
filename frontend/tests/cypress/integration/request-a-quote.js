/* eslint-disable no-undef */
describe('Request a quote page', function() {
  // a very rudimentary test :)
  it('should be able to open request a quote page', function() {
    cy.visit('/devis')
    cy.contains('Assainissement').should('exist')
  })
})
