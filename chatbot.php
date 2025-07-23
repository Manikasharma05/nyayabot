
---

### **chatbot.php**
```php
<?php
header('Content-Type: application/json');
require 'vendor/autoload.php'; // Ensure you've run: `composer require openai-php/client`

$input = json_decode(file_get_contents('php://input'), true);
$userMessage = $input['message'] ?? '';
$language = $input['language'] ?? 'en'; // 'en' or 'hi'
$history = $input['history'] ?? [];

// Initialize OpenAI client
$client = OpenAI::client('YOUR_OPENAI_API_KEY'); // Replace with your actual key

// Legal system prompt (bilingual)
$systemPrompt = [
    'en' => "You are NyayaBot, a legal assistant for Indian crime victims. Provide:
1. Immediate steps (FIR filing, evidence preservation)
2. Relevant IPC/CrPC sections with punishments
3. Contact info for NGOs/authorities (format: [Name] - [Phone])
4. Next legal procedures
Guidelines:
- Use simple language
- For Hindi queries, respond in Hindi
- Cite laws like 'IPC 376: Rape (10+ years imprisonment)'
- Never suggest illegal actions",
    
    'hi' => "आप न्यायबॉट हैं, भारत में अपराध पीड़ितों के लिए कानूनी सहायक। प्रदान करें:
1. तत्काल कदम (FIR दर्ज करना, सबूत सुरक्षित करना)
2. प्रासंगिक IPC/CrPC धाराएं व सजा
3. एनजीओ/अधिकारियों का संपर्क विवरण (प्रारूप: [नाम] - [फोन])
4. आगे की कानूनी प्रक्रिया
दिशानिर्देश:
- सरल भाषा का प्रयोग करें
- कानूनों को 'IPC 376: बलात्कार (10+ वर्ष कारावास)' के रूप में उल्लेख करें
- अवैध कार्यों का सुझाव कभी न दें"
];

try {
    // Prepare messages array
    $messages = [
        ['role' => 'system', 'content' => $systemPrompt[$language]]
    ];

    // Add conversation history
    foreach ($history as $msg) {
        $messages[] = ['role' => $msg['role'], 'content' => $msg['content']];
    }

    // Add current user message
    $messages[] = ['role' => 'user', 'content' => $userMessage];

    // Get response from OpenAI
    $response = $client->chat()->create([
        'model' => 'gpt-3.5-turbo',
        'messages' => $messages,
        'temperature' => 0.3, // Lower for legal accuracy
        'max_tokens' => 500
    ]);

    // Format response
    $botResponse = $response->choices[0]->message->content;

    // Log interaction (optional)
    file_put_contents('chat_logs.txt', date('Y-m-d H:i:s')." | $userMessage | $botResponse\n", FILE_APPEND);

    echo json_encode([
        'reply' => $botResponse,
        'status' => 'success'
    ]);

} catch (Exception $e) {
    // Fallback response if API fails
    $fallback = [
        'en' => "I'm unable to respond currently. Please contact National Legal Services Authority at 1800-11-0009 for immediate help.",
        'hi' => "मैं अभी उत्तर नहीं दे पा रहा। तत्काल सहायता के लिए राष्ट्रीय विधिक सेवा प्राधिकरण से 1800-11-0009 पर संपर्क करें।"
    ];
    
    echo json_encode([
        'reply' => $fallback[$language],
        'status' => 'error'
    ]);
}
?>