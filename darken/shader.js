function encrypt(str)
{
	var top_shadow = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "1","2", "3", "4", "5", "6", "7", "8", "9","0", "!", '"', "£", "$", "%", "^", "&", "*", "(", ")","_", "-", "+", "=", ":", ";","@", "'", "<", ",",">", "/", "?", ".", "{", "[", "}", "]", "~", "#", "\\","¬","`","A","B","C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
	
	var bottom_shadow = ["1x", "a9", "q5", "K5", "87", "jk", "p1", "0x", "xl", "p8", "la", "mj", "t1", "9g", "kp", "41", "9b", "7k", "bc", "mX", "z9", "gh", "f7", "h8", "a6", "j1", "uj", "hl", "0j", "6y", "k1", "ap", "fg", "jN", "0k", "1j", "0u", "2j", "j7", "7s", "O2", "j9", "mN", "0o", "l2", "uV", "fH", "63", "y7", "bm", "aA", "hj", "77", "k3", "po", "78", "bh", "vk", "uA", "02", "5t", "8u", "90", "lq", "tu", "60", "ak", "09", "67", "hi", "yr", "Jf", "9j", "7h", "bu", "ln", "g2", "91", "b7", "iO", "Rh", "08", "7g", "jO", "uy", "0y", "9U", "lK", "p4", "jg", "ho", "jv", "bk", "0d", "Ih", "Xa"];

	var length = str.length;
	content_holder = '';
	content_accumulator = '';
	for (i=0; i < length; i++) 
	{
		component = str[i];
		for (x=0; x < top_shadow.length; x++) 
		{ 
			if (component == top_shadow[x]) 
			{
				content_holder = bottom_shadow[x];
			}
		}
		content_accumulator = content_accumulator+content_holder;
	}
	return content_accumulator;
}
function decrypt(str)
{
	var top_shadow = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "1","2", "3", "4", "5", "6", "7", "8", "9","0", "!", '"', "£", "$", "%", "^", "&", "*", "(", ")","_", "-", "+", "=", ":", ";","@", "'", "<", ",",">", "/", "?", ".", "{", "[", "}", "]", "~", "#", "\\","¬","`","A","B","C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
	
	var bottom_shadow = ["1x", "a9", "q5", "K5", "87", "jk", "p1", "0x", "xl", "p8", "la", "mj", "t1", "9g", "kp", "41", "9b", "7k", "bc", "mX", "z9", "gh", "f7", "h8", "a6", "j1", "uj", "hl", "0j", "6y", "k1", "ap", "fg", "jN", "0k", "1j", "0u", "2j", "j7", "7s", "O2", "j9", "mN", "0o", "l2", "uV", "fH", "63", "y7", "bm", "aA", "hj", "77", "k3", "po", "78", "bh", "vk", "uA", "02", "5t", "8u", "90", "lq", "tu", "60", "ak", "09", "67", "hi", "yr", "Jf", "9j", "7h", "bu", "ln", "g2", "91", "b7", "iO", "Rh", "08", "7g", "jO", "uy", "0y", "9U", "lK", "p4", "jg", "ho", "jv", "bk", "0d", "Ih", "Xa"];

	var length = str.length/2;
	content_holder = '';
	content_accumulator = '';
	for (i=0; i < length; i++) 
	{
		if (i == 0) 
		{
			y = i;
			z = 2;
		}
		else
		{
			y = y + 2;
			z = y + 2;
		}
		component = str.substring(y, z);
		for (x=0; x < top_shadow.length; x++) 
		{ 
			if (component == bottom_shadow[x]) 
			{
				content_holder = top_shadow[x];
			}
		}
		content_accumulator = content_accumulator+content_holder;
	}
	return content_accumulator;
}