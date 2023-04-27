/* eslint-disable no-undef */
describe('api', function() {
  beforeEach(() => {
    cy.fixture('users/johndoe').as('john')
  })

  it('should be able to visit an open API route', function() {
    cy.visit('/api')
    cy.contains('wedo.lu open api').should('exist')
  })

  it('should not be able to visit a protected API route', function() {
    cy.request({
      url: '/api/user',
      failOnStatusCode: false
    }).then(response => {
      expect(response.status).to.eq(400)
      expect(response.body).to.have.property('error', 'Unauthorized')
    })
  })

  it('should be able to login via API', function() {
    cy.request('POST', '/api/login', {
      email: this.john.email,
      password: this.john.password
    }).then(response => {
      expect(response.status).to.eq(200)
      expect(response.body).to.have.property('status', 'success')
      expect(response.body).to.have.property('token')
    })
  })
})
