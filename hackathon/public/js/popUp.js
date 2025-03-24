document.addEventListener('DOMContentLoaded', function () {
  console.log('✅ DOM fully loaded.');

  const conservationList = document.getElementById('conservationList');
  const dynamicContent = document.getElementById('dynamicContent');

  if (!conservationList || !dynamicContent) {
      console.error('❌ Error: Required elements not found.');
      return;
  }

  conservationList.addEventListener('click', function (event) {
      const easementItem = event.target.closest('.easement-item');
      if (!easementItem) return;

      event.preventDefault();
      const easementId = easementItem.getAttribute('data-id');
      if (!easementId) {
          console.error('❌ Error: No data-id found.');
          return;
      }

      console.log(`🟢 Fetching data for ID: ${easementId}`);
      // change path for getEasement.php
      fetch('getEasement.php?id=' + encodeURIComponent(easementId))
          .then(response => response.text())
          .then(data => {
              console.log('🟢 Received Data:', data);
              dynamicContent.innerHTML = data;

              // Remove any existing buttons (close, download, share)
              document.querySelectorAll('.close-button, .download-button, .share-button').forEach(el => el.remove());

              // Create Close Button
              const closeBtn = document.createElement('button');
              closeBtn.className = 'close-button';
              closeBtn.textContent = '✖️';
              closeBtn.style.position = 'absolute';
              closeBtn.style.top = '10px';
              closeBtn.style.right = '10px';
              dynamicContent.appendChild(closeBtn);

              // Create Download Button (calls PHP script)
              const downloadBtn = document.createElement('a');
              downloadBtn.className = 'download-button';
              downloadBtn.innerHTML = `<img src="https://www.citypng.com/public/uploads/preview/download-downloading-save-black-icon-button-png-701751694964960mnimcmxgyh.png" alt="Download" style="width:20px; height:20px;">`;
              downloadBtn.style.position = 'absolute';
              downloadBtn.style.top = '10px';
              downloadBtn.style.right = '50px';
              
              // Prepare parameters to pass to pdf.php
              const params = new URLSearchParams();
              params.append('title', easementItem.textContent.trim());

              dynamicContent.querySelectorAll('p, h1, h2, h3, h4, span, li').forEach(el => {
                  if (el.textContent.trim()) {
                      params.append('content[]', el.textContent.trim());
                  }
              });

              // Extract image source if available
              const imageElement = dynamicContent.querySelector('img');
              if (imageElement) {
                  params.append('image', imageElement.src);
              } else {
                  console.warn('⚠️ No image found inside dynamicContent');
              }

              // Create the PDF URL (same as used for download)
              // make path change to pdf.php
              const pdfUrl = `pdf.php?${params.toString()}`;

              // Set href for download button (calls pdf.php with params)
              downloadBtn.href = pdfUrl;
              // make a path change to easement.pdf 
              downloadBtn.setAttribute('download', 'easement.pdf');
              dynamicContent.appendChild(downloadBtn);

              // Create Share Button (positioned to the left of the download button)
              const shareBtn = document.createElement('button');
              shareBtn.className = 'share-button';
              shareBtn.textContent = 'Share';
              shareBtn.style.position = 'absolute';
              shareBtn.style.top = '10px';
              shareBtn.style.right = '90px';
              dynamicContent.appendChild(shareBtn);

              // Add share functionality: share the PDF URL directly
              shareBtn.addEventListener('click', function () {
                  if (navigator.share) {
                      navigator.share({
                          title: easementItem.textContent.trim(),
                          text: 'Check out this easement detail!',
                          url: pdfUrl
                      })
                      .then(() => console.log('Thanks for sharing!'))
                      .catch(error => console.error('Share failed:', error));
                  } else {
                      // Fallback: create a popup with a clickable link
                      const popup = document.createElement('div');
                      popup.style.position = 'fixed';
                      popup.style.top = '50%';
                      popup.style.left = '50%';
                      popup.style.transform = 'translate(-50%, -50%)';
                      popup.style.backgroundColor = 'white';
                      popup.style.border = '1px solid #ccc';
                      popup.style.padding = '20px';
                      popup.style.zIndex = '100000';
                      popup.style.boxShadow = '0 0 15px rgba(0, 0, 0, 0.3)';
                      popup.style.textAlign = 'center';

                      // Message above the link
                      const message = document.createElement('p');
                      message.textContent = 'Browser does not support sharing, please';
                      message.style.marginBottom = '10px';
                      popup.appendChild(message);

                      // Clickable PDF link
                      const link = document.createElement('a');
                      link.href = pdfUrl;
                      link.textContent = 'Click here to view/download PDF';
                      link.style.fontSize = '16px';
                      link.style.color = '#17836f';
                      link.style.textDecoration = 'none';
                      link.style.display = 'block';
                      link.style.marginBottom = '10px';
                      popup.appendChild(link);

                      // Close button for popup
                      const popupClose = document.createElement('button');
                      popupClose.textContent = 'Close';
                      popupClose.style.padding = '5px 10px';
                      popupClose.addEventListener('click', function () {
                          document.body.removeChild(popup);
                      });
                      popup.appendChild(popupClose);

                      document.body.appendChild(popup);
                  }
              });

              // Close button functionality to hide the modal
              closeBtn.addEventListener('click', function () {
                  dynamicContent.style.display = 'none';
              });

              // Show the modal with the dynamic content and buttons
              dynamicContent.style.display = 'block';
          })
          .catch(error => {
              console.error('❌ Fetch Error:', error);
          });
  });
});