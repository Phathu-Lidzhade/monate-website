const accountContainer = document.querySelector('.account-container');
  const accountDropdown = document.querySelector('.account-dropdown');
  if(accountContainer && accountDropdown){
    accountContainer.addEventListener('click', () => {
      accountDropdown.style.display =
        accountDropdown.style.display === 'block' ? 'none' : 'block';
    });
  }

  // Branch dropdown toggle
  const branchContainer = document.querySelector('.branch-container');
  const branchDropdown = document.querySelector('.branch-dropdown');
  if(branchContainer && branchDropdown){
    branchContainer.addEventListener('click', () => {
      branchDropdown.style.display =
        branchDropdown.style.display === 'block' ? 'none' : 'block';
    });
  }