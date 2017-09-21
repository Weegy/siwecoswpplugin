<?php
/**
 * Created by PhpStorm.
 * User: wege
 * Date: 19.09.2017
 * Time: 13:32
 */
function siewecos_dasboard() {

	wp_add_dashboard_widget(
		'siwecos_dashboard_wirdget',         // Widget slug.
		'SIWECOS Security Scanner',         // Title.
		'siewecos_dasboard_function' // Display function.
	);
}

/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function siewecos_dasboard_function() {
	$html      = '';
	$usertoken = get_option( USER_TOKEN );
	if ( isset( $usertoken ) && ! empty( $usertoken ) ) {
		// Check if not empty
		$apicon   = new apiConnector();
		$username = get_option( USER_NAME );
		$domains  = $apicon->GetDomainsForUser( $usertoken )['data'];
		$html     .= '<h3>Logged in: ' . $username . '</h3>';
		$html     .= '<hr/>';
		$html     .= '<h3>Domains</h3>';
		$html     .= '<div class="domain-list">';
		foreach ( $domains as $domain ) {
			$html .= '<h4 class="domain--item" id="' . $domain->id . '">' . $domain->address . '</h6>';
			//Load Scan Results
			$domainResult = $apicon->GetScanResultForDomainId( $domain->id )['data'];
			$html         .= '<div id="domain_result_' . $domain->id . '" class="domain--results">';
			if ( $domainResult != null ) {
				$html .= '<div id="el"  data-value="' . $domainResult->value . '">
						  <span style="transform: rotate(' . ( 180 * ( $domainResult->value / 100 ) ) . 'deg);" id="needle"></span>
						  </div>';
				$html .= '<p>SecurityScore: ' . $domainResult->value . '/100</p>';
				$html .= '<p>Letzter Scan: ' . $domainResult->lastScan . '</p>';
				$html .= '<hr/>';
				$html .= '<div class="scan--result">';

				$html .= '<h4>Ergebnisse</h4>';
				foreach ( $domainResult->scanners as $scanner ) {
					$html .= '<p class="scanner--item">' . $scanner->name . '</p>';
					$html .= '<div class="scanner--result-item">';
					$html .= '<div id="el"  data-value="' . $scanner->value . '">
						  <span style="transform: rotate(' . ( 180 * ( $scanner->value / 100 ) ) . 'deg);" id="needle"></span>
						  </div>';
					$html .= '<div class="scanner--checks">';
					foreach ( $scanner->scanchecks as $scancheck)
					{
						$html .= '<p>' . $scancheck->name . '</p>';
						$html .= '<p>' . $scancheck->description . '</p>';
					}
					$html .= "</div>";
					$html .= '</div>';
				}
				$html .= '</div>';
			} else {
				$html .= '<p>Noch keine Ergebnisse vorhanden!</p>';
			}


			$html .= '</div>';
		}
		$html .= '</div>';
		$html .= '<hr/>';
		$html .= '<button id="logout_button">Logout</button>';
	} else {
		// If empty show login
		$html .= '<div class="container">
    <label><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" id="uname" required>
    <br/>
    <label><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

    <button id="login_button">Login</button>
</div>';
	}
	echo $html;
}
