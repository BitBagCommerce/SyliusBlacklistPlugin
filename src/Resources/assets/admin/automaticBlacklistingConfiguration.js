$(() => {
  const addRuleBtn = document.querySelector('[data-form-collection="add"]');

  const turnOnListener = () => {
    addRuleBtn?.addEventListener('click', () => {
      const configurationTypeSelects = document.querySelectorAll('[data-form-collection="update"]');
      const changeEvent = new Event('change', { 'bubbles': true });

      configurationTypeSelects[configurationTypeSelects.length - 1].dispatchEvent(changeEvent);
    });
  }

  turnOnListener();
})

