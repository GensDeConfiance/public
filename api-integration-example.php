<?php
$apiPartnerId = 'YOUR-PARTNER-ID';
$apiPartnerSecret = 'YOUR-PARTNER-SECRET';

$email = 'nicolas@gensdeconfiance.fr';

//construction de l'url
$url = sprintf('https://gensdeconfiance.fr/api/member/check.json?email=%s&apiPartnerId=%s&apiPartnerSecret=%s', $email, $apiPartnerId, $apiPartnerSecret);

//récupère les informations
$json = file_get_contents($url, true);
$data = json_decode($json, true);

if ($data['success']) {
  //logique métier
  if ('member' === $data['response']['status']) {
    echo "dans la base de donnée";
    echo $data['response']['nb_referrers'] . " parrain(s)";
    echo sprintf('<a href="%s?utm_source=%s&utm_medium=badge&utm_campaign=badgeGDC%s&origin=%s">Page de profil GDC</a>', $data['response']['profile_url'], $apiPartnerId, $apiPartnerId, $apiPartnerId);
    //save in database
  } elseif ('pending' === $data['response']['status']) {
    echo "inscrit gdc mais pas membre";
    //inscrit GdC mais pas membre
  } elseif ('unknown' === $data['response']['status']) {
    echo "inconnu";
    //inconnu
  }
} else {
  echo "echec";
  //echec de l'appel à l'api (mauvais logins, adresse email mal formatée...)
}
