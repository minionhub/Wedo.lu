describe('Register page', function() {
  it('It should register new user.', function() {
    cy.viewport(1920, 951)

    cy.visit('/my-account')

    cy.contains('Connectez-vous').should('exist')

    cy.get('form[data-vv-scope="register"] input[name="name"]').type('New user')

    cy.get('form[data-vv-scope="register"] input[name="email"]').type(
      'newuser@wedo.lu'
    )

    cy.get('form[data-vv-scope="register"] input[name="password"]').type(
      'Abcdefg12345'
    )

    cy.get('form[data-vv-scope="register"] input[name="terms"]').check('on')

    cy.get('form[data-vv-scope="register"] input[name="secret"]').check('on')

    cy.get('form[data-vv-scope="register"] button')
      .contains("S'inscrire")
      .click()

    cy.contains('Connectez-vous').should('not.exist')

    cy.contains('Bienvenue New user').should('be.visible')

    cy.location('pathname').should('eq', '/dashboard')
  })

  it('Login fails. Show error message(Email already exists.)', function() {
    cy.viewport(1920, 951)

    cy.visit('/my-account')

    cy.contains('Connectez-vous').should('exist')

    cy.get('form[data-vv-scope="register"] input[name="name"]').type('New user')

    cy.get('form[data-vv-scope="register"] input[name="email"]').type(
      'newuser@wedo.lu'
    )

    cy.get('form[data-vv-scope="register"] input[name="password"]').type(
      'Abcdefg12345'
    )

    cy.get('form[data-vv-scope="register"] input[name="terms"]').check('on')

    cy.get('form[data-vv-scope="register"] input[name="secret"]').check('on')

    cy.get('form[data-vv-scope="register"] button')
      .contains("S'inscrire")
      .click()

    cy.contains('Connectez-vous').should('exist')

    cy.contains(
      'Un compte est déjà enregistré avec votre adresse e-mail'
    ).should('exist')
  })
})
