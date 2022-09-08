//require('@fancyapps/fancybox');
import { Fancybox } from '@fancyapps/ui';
// import '@fancyapps/ui/dist/fancybox.css';

Fancybox.bind(
	"a[href$='.jpg']:not([target]):not([download]), a[href$='.jpeg']:not([target]):not([download]), a[href$='.png']:not([target]):not([download]), a[href$='.gif']:not([target]):not([download]), a[href$='.svg']:not([target]):not([download]), a[href$='.webp']:not([target]):not([download])",
	{
		groupAll: true,
	}
);
