<?php
include __DIR__ . '/Includes/header.php';
?>
<h2 class="text-4xl mb-6 border-b border-gray-700 pb-2">Documentation</h2>
<p class="mb-8 text-lg leading-relaxed">Welcome to the NatterBase documentation. This guide will help you understand how to use the site and its features.</p>

<div class="flex flex-col sm:flex-row sm:space-x-4">
  <nav class="mb-12 bg-gray-900 p-6 rounded-lg shadow-lg w-72 min-w-72">
    <h2 class="text-2xl font-semibold mb-4">Table of Contents</h2>
    <ul class="space-y-3">
      <li>
        <a href="#about" class="flex items-center text-blue-400 hover:text-blue-500">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor">
            <path d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm-40-160h80v-240h-80v240Zm40 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
          </svg>
          About NatterBase
        </a>
      </li>
      <li>
        <a href="#usage" class="flex items-center text-blue-400 hover:text-blue-500">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor">
            <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z" />
          </svg>
          Creating an account
        </a>
      </li>
      <li>
        <a href="#getting-started" class="flex items-center text-blue-400 hover:text-blue-500">
          <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path d="M4 3a1 1 0 000 2h12a1 1 0 100-2H4zM3 7a1 1 0 000 2h14a1 1 0 100-2H3zm3 4a1 1 0 000 2h8a1 1 0 100-2H6zm-2 4a1 1 0 000 2h12a1 1 0 100-2H4z" />
          </svg>
          Getting Started
        </a>
      </li>
      <li>
        <a href="#features" class="flex items-center text-blue-400 hover:text-blue-500">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor">
            <path d="m422-232 207-248H469l29-227-185 267h139l-30 208ZM320-80l40-280H160l360-520h80l-40 320h240L400-80h-80Zm151-390Z" />
          </svg>
          Features
        </a>
      </li>
      <li>
        <a href="#security" class="flex items-center text-blue-400 hover:text-blue-500">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor">
            <path d="m438-338 226-226-57-57-169 169-84-84-57 57 141 141Zm42 258q-139-35-229.5-159.5T160-516v-244l320-120 320 120v244q0 152-90.5 276.5T480-80Zm0-84q104-33 172-132t68-220v-189l-240-90-240 90v189q0 121 68 220t172 132Zm0-316Z" />
          </svg>
          Security and Privacy
        </a>
      </li>
    </ul>
  </nav>

  <section id="about" class="mb-12">
    <h2 class="text-2xl font-bold mb-4 border-b border-gray-700 pb-2">About NatterBase</h2>
    <p class="text-gray-300 leading-relaxed">NatterBase is a platform that allows you to run your own chatbot locally.</p>
  </section>
</div>

<section id="usage" class="mb-12">
  <h2 class="text-2xl font-bold mb-4 border-b border-gray-700 pb-2">Creating an account</h2>
  <p class="text-gray-300 leading-relaxed">First you will have to create an account to use our application. Click "Web app" on the top right and either log in or click the link to open the registration form.</p>
  <p class="text-gray-300 leading-relaxed">You will then receive a mail with a link to activate your account. Once activated you can login and start using the app.</p>
</section>

<section id="getting-started" class="mb-12">
  <h2 class="text-2xl font-bold mb-4 border-b border-gray-700 pb-2">Getting Started</h2>
  <p class="text-gray-300 mb-4">To start using our app, follow these steps:</p>
  <ol class="space-y-3 ml-5 list-decimal text-gray-300">
    <li>Get a Twitch token here <a href="https://twitchtokengenerator.com/" target="_blank" class="text-blue-400 hover:text-blue-500">https://twitchtokengenerator.com/</a>. Select Bot Chat Token and click "Authorize" to get a token for your Twitch account.</li>
    <li>Copy the token, go back to our app and paste the token in "Local Keys".</li>
    <li>If you want to use AI features for your bot, get an OpenAI API key as well : <a href="https://beta.openai.com/account/api-keys" target="_blank" class="text-blue-400 hover:text-blue-500">https://beta.openai.com/account/api-keys</a>.</li>
    <li>In our app, create a new bot by clicking the "New Bot" button. Select your new bot in the list.</li>
    <li>In the "Bot settings" section, enter the channel name you want the bot to join. Don't forget to click save.</li>
    <li>You can add features to your bot in the "Bot Features" section. More info about each feature can be found down below.</li>
    <li>Click save if you added or modified any features, and click "Run Bot" !</li>
  </ol>
  <p class="text-gray-300 pt-4">There you go, you can go to the chat section and should be able to see the messages of the channel you are connected to.</p>
</section>

<section id="features" class="mb-12">
  <h2 class="text-2xl font-bold mb-4 border-b border-gray-700 pb-2">Features</h2>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-gray-900 p-6 rounded-lg shadow-lg">
      <h3 class="text-xl font-semibold mb-2">General information</h3>
      <h4>Trigger</h4>
      <p class="text-gray-300">If a message starts with this, the bot will execute the feature. It's recommended you use a prefix like "!" to avoid conflicts.</p>
      <p>Example usage : "!ask Why is the sky blue ?"</p>
      <p class="text-gray-300">Use @ as a trigger and the bot will execute the feature when someone @s the bot.</p>
      <p>Example usage : @Natterbase How are you ?</p>
    </div>
    <div class="bg-gray-900 p-6 rounded-lg shadow-lg">
      <h3 class="text-xl font-semibold mb-2">Dice roll</h3>
      <p class="text-gray-300">Will roll a dice with the number of sides you specify.</p>
    </div>
    <div class="bg-gray-900 p-6 rounded-lg shadow-lg">
      <h3 class="text-xl font-semibold mb-2">AI chat</h3>
      <p class="text-red-600">An OpenAI API key must be set in the "Local Keys" section.</p>
      <p class="text-gray-300">Will use the OpenAI API to generate a response.</p>
      <p class="text-gray-300">Pre-prompt :</p>
      <p>The bot will use this prompt to generate the response. For example you can ask it to behave in a certain way.</p>
    </div>
  </div>
</section>

<section id="security" class="mb-12">
  <h2 class="text-2xl font-bold mb-4 border-b border-gray-700 pb-2">Security and Privacy</h2>
  <p class="text-gray-300 leading-relaxed">NatterBase prioritizes your security and privacy. We only store your email and password hash. Your keys are not stored in our database; they are kept locally in your browser. This ensures that only you have access to your sensitive information.</p>
  <p class="text-gray-300 leading-relaxed">Ensure that you do not share your device with untrusted individuals to maintain the security of your keys.</p>
</section>

<?php
include __DIR__ . '/Includes/footer.html';
?>