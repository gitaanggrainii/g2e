
document.addEventListener("DOMContentLoaded", function () {
  const methods = document.querySelectorAll('input[name="payment-method"]');
  const subMethods = document.querySelectorAll('.sub-method');
  let activeId = null;

  subMethods.forEach(sm => sm.style.display = 'none');

  methods.forEach(method => {
    method.addEventListener('click', function () {
      const targetId = this.id + '-sub-method';
      const targetDiv = document.getElementById(targetId);

      if (activeId === targetId) {
        targetDiv.style.display = 'none';
        this.checked = false;
        activeId = null;
      } else {
        subMethods.forEach(sm => sm.style.display = 'none');
        methods.forEach(m => m.checked = false);
        this.checked = true;
        targetDiv.style.display = 'block';
        activeId = targetId;
      }
    });
  });
});