/**
 * Send check code request.
 */
async function checkCode(form) {
  const res = await $.ajax({
    type: 'POST',
    url: '/api/mfa/checkCode',
    data: new FormData(form),
    contentType: false,
    processData: false
  });

  if(res) location.href = '/dashboard';
  else alert('code error or reload for new key');
}

(async () => {
  // Click the mfa submit button.
  $('[on-mfa]').on('submit', async event => {
    event.preventDefault();

    await checkCode(event.currentTarget);
  });
})();