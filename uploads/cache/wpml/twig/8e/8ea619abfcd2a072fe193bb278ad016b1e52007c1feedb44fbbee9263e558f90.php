<?php

namespace WPML\Core;

use \WPML\Core\Twig\Environment;
use \WPML\Core\Twig\Error\LoaderError;
use \WPML\Core\Twig\Error\RuntimeError;
use \WPML\Core\Twig\Markup;
use \WPML\Core\Twig\Sandbox\SecurityError;
use \WPML\Core\Twig\Sandbox\SecurityNotAllowedTagError;
use \WPML\Core\Twig\Sandbox\SecurityNotAllowedFilterError;
use \WPML\Core\Twig\Sandbox\SecurityNotAllowedFunctionError;
use \WPML\Core\Twig\Source;
use \WPML\Core\Twig\Template;

/* setup-wizard-buttons.twig */
class __TwigTemplate_c0c506c48b1e6ff5bb89bead7b94d3dbcc27bc816b39ebb141fe79194a81bb6a extends \WPML\Core\Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        if ( !($context["setup_complete"] ?? null)) {
            // line 2
            echo "\t<footer id=\"icl_setup_nav_3\" class=\"js-wpml-ls-section wpml-section clearfix text-right\">
\t\t<input id=\"icl_setup_back_2\" class=\"button-secondary alignleft\" name=\"save\" value=\"";
            // line 3
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "misc", []), "button_back", []), "html", null, true);
            echo "\" type=\"button\" />
\t\t";
            // line 4
            echo ($context["setup_step_2_nonce_field"] ?? null);
            echo "
\t\t<input class=\"button-primary alignright\" name=\"save\" value=\"";
            // line 5
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "misc", []), "button_next", []), "html", null, true);
            echo "\" type=\"submit\" />
\t\t<input type=\"hidden\" name=\"submit_setup_wizard\" value=\"0\" />
\t</footer>
";
        }
    }

    public function getTemplateName()
    {
        return "setup-wizard-buttons.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  45 => 5,  41 => 4,  37 => 3,  34 => 2,  32 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "setup-wizard-buttons.twig", "/Applications/MAMP/htdocs/smecta/wp-content/plugins/sitepress-multilingual-cms/templates/language-switcher-admin-ui/setup-wizard-buttons.twig");
    }
}
