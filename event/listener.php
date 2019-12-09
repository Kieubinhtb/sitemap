<?php
/**
*
* SEO Sitemap
* @copyright (c) 2016 Jeff Cocking
* @copyright (c) 2019 Paul Norman (WelshPaul)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace welshpaul\sitemap\event;

use phpbb\config\config;
use phpbb\template\template;
use phpbb\controller\helper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	protected $config;
	protected $template;
	protected $helper;

	public function __construct(config $config, template $template, helper $helper)
	{
		$this->config = $config;
		$this->template = $template;
		$this->helper = $helper;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'	=> 'load_language_on_setup',
			'core.page_header'	=> 'welshpaul_sitemap_set_tpl_data',
		);
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'welshpaul/sitemap',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * Set Sitemap template data
	 *
	 * @return null
	 * @access public
	 */
	public function welshpaul_sitemap_set_tpl_data()
	{

		if ($this->config['welshpaul_sitemap_link'])
		{
			$this->template->assign_var('S_WELSHPAUL_SITEMAP_LINK', $this->config['welshpaul_sitemap_link']);
			$this->template->assign_var('WELSHPAUL_SITEMAP_URL', $this->helper->route('welshpaul_sitemap_sitemapindex', array(), true, '', \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL));
		}
	}
}
