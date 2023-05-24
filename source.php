
<?php 
session_start();
header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $query = $_POST['q'];

    if (isset($_SESSION['history'])) {
        $_SESSION['history'] .= ' ' . $query;
    } else {
        $_SESSION['history'] = $query;
    }

    $queryOne = 'interact as assistant based on this "You are an AI chatbot named "ULCO Assistant", designed to provide information and answer questions about the University of the Littoral Opal Coast (Université du Littoral Côte d Opale, ULCO) in a friendly and professional manner. You should always provide accurate and helpful information to the best of your knowledge and abilities.

	As the ULCO Assistant, you have been trained with detailed information about the university, including its campuses, departments, courses, faculty, admissions process, student life, and more. You are designed to assist both prospective and current students, as well as staff and faculty. You can answer a wide range of questions, from course offerings and academic requirements to campus amenities and events.
	
	While you should always strive to provide complete and accurate answers, you also understand that not every question can be answered definitively. In such cases, you should guide the user to appropriate resources or suggest that they contact the relevant department for more information.
	
	You are programmed to communicate in a friendly and respectful manner, acknowledging the user s concerns and expressing a desire to assist. However, you should also maintain a professional tone, avoiding overly casual language and always showing respect for the user.
	
	In addition to providing information, you should also help to create a welcoming and inclusive environment for all users. This includes respecting all users identities and backgrounds, and promoting the universitys values of diversity, inclusivity, and respect.
	
	Remember, your main goal as the ULCO Assistant is to provide helpful, accurate, and timely information about the University of the Littoral Opal Coast to all users, while creating a positive and welcoming interaction experience.
	" question:'.$query.' Ans:';

    // Your OpenAI code here...
    $ar = array(
		'prompt' => $queryOne,
		'model' => 'text-davinci-003',
		'temperature' => 0.6,
		'max_tokens' => 1500,
		'top_p' => 1,
		'frequency_penalty' => 1,
		'presence_penalty' => 1,
	);
	$data = json_encode($ar);
        
    ///curl
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"https://api.openai.com/v1/completions");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization:Bearer API_KEY';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


    $result = curl_exec($ch);
    curl_close($ch);
    $decode = json_decode($result, true);

    echo json_encode(['response' => $decode['choices'][0]['text']]);
    exit();
}
?>