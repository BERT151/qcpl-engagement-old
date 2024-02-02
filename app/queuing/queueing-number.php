<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Categorized Queue Number Display</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      text-align: center;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      color: #333;
    }

    header {
      background-color: #13a561;
      color: #fff;
      font-size: 24px;
    }

    .container {
      padding: 20px;
      max-width: 400px;
      display: flex;
      justify-content:flex-end ;
      flex-direction: column;
    }

    .queue-category {
      margin-bottom: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
    }

    .queue-number {
      font-size: 48px;
      margin: 20px 0;
      color: #3498db;
    }

    video {
      width: 60%;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    #movieSection{
      transform: translate(15%,-100%);
      position: relative;
      
    }
  </style>
</head>
<body>

  <header>
    Queue Number Display
  </header>

  <div class="container">

    <div class="queue-category">
      <h2>NBI Queue</h2>
      <div class="queue-number" id="nbiQueueNumber">Loading...</div>
    </div>

    <div class="queue-category">
      <h2>Police Clearance Queue</h2>
      <div class="queue-number" id="policeQueueNumber">Loading...</div>
    </div>

    <div class="queue-category">
      <h2>Others Queue</h2>
      <div class="queue-number" id="othersQueueNumber">Loading...</div>
    </div>



  </div>
      <!-- Movie Section -->
      <div id="movieSection">
      <h2>Now Showing</h2>
      <video controls>
        <source src="your-movie-file.mp4" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div>

  <script>
    // Simulated function to get the updated queue number from the backend
    function getUpdatedQueueNumber(category) {
      // Replace this with actual logic to fetch the queue number from the backend
      return Math.floor(Math.random() * 100) + 1;
    }

    // Function to update the queue number on the webpage
    function updateQueueNumber(category) {
      const queueNumberElement = document.getElementById(`${category}QueueNumber`);
      const newQueueNumber = getUpdatedQueueNumber(category);
      queueNumberElement.innerText = newQueueNumber;
    }

    // Initial update when the page loads
    window.onload = function () {
      updateQueueNumber('nbi');
      updateQueueNumber('police');
      updateQueueNumber('others');
    };
  </script>

</body>
</html>
