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

  // Authenticating code failed.
  if (res.error) return void alert('The code is incorrect.');

  // Authenticating code successful.
  location.href = '/dashboard';
}

(async () => {
  // Click the mfa submit button.
  $('[on-mfa]').on('submit', async event => {
    event.preventDefault();

    await checkCode(event.currentTarget);
  });
})();