<?=doctype('xml_title');?>
<journal>
	<operCard>
		<operator>Articulus_2008</operator>
		<pid>136378</pid>
		<date>2013-11-1 0:34:01</date>
		<cntArticle>1</cntArticle>
		<cntNode></cntNode>
		<cs>0</cs>
	</operCard>
	<titleid>32527</titleid>
	<issn>2073-0373</issn>
	<codeNEB>20730373</codeNEB>
	<journalInfo lang="RUS">
		<title>Фазовые переходы, упорядоченные состояния и новые материалы</title>
	</journalInfo>
	<journalInfo lang="ENG">
		<title>Phase transitions, ordered states and new materials</title>
	</journalInfo>
	<issue>
		<volume></volume>
		<number><?=$issue['id'];?></number>
		<altNumber></altNumber>
		<part></part>
		<dateUni><?=$issue['year'].str_pad($issue['month'],2,'0',STR_PAD_LEFT)?></dateUni>
		<issTitle></issTitle>
		<pages></pages>
		<articles>
		<?php for($i=0;$i<count($publications);$i++):?>
			<article>
				<pages><?=$publications[$i]['page'];?></pages>
				<artType>RAR</artType>
				<authors>
				<?php foreach($publications[$i]['authors'] as $key => $autor):?>
					<author num="<?=str_pad($key+1,3,'0',STR_PAD_LEFT);?>">
						<individInfo lang="RUS">
							<surname><?=$autor['ru_name'];?></surname>
							<initials><?=getInitials($autor['ru_name']);?></initials>
							<email><?=$autor['email']?></email>
							<orgName><?=$autor['ru_title']?></orgName>
						</individInfo>
						<individInfo lang="ENG">
							<surname><?=$autor['en_name'];?></surname>
							<initials><?=getInitials($autor['en_name']);?></initials>
							<email><?=$autor['email']?></email>
							<orgName><?=$autor['en_title']?></orgName>
						</individInfo>
					</author>
				<?php endforeach;?>
				</authors>
				<artTitles>
					<artTitle lang="RUS"><?=htmlspecialchars($publications[$i]['ru_title']);?></artTitle>
					<artTitle lang="ENG"><?=htmlspecialchars($publications[$i]['en_title']);?></artTitle>
				</artTitles>
				<abstracts>
					<abstract lang="RUS"><?=htmlspecialchars(strip_tags($publications[$i]['ru_annotation']));?></abstract>
					<abstract lang="ENG"><?=htmlspecialchars(strip_tags($publications[$i]['en_annotation']));?></abstract>
				</abstracts>
				<text lang="RUS"></text>
				<text lang="ENG"></text>
				<keywords>
					<kwdGroup lang="ANY">
					<?php foreach($publications[$i]['keywords'] as $key => $keyword):?>
						<keyword><?=$keyword;?></keyword>
					<?php endforeach;?>
					</kwdGroup>
				</keywords>
				<references>
					<reference></reference>
				</references>
				<files>
				<?php foreach($publications[$i]['files'] as $key => $file):?>
					<file><?=$file;?></file>
				<?php endforeach;?>
				</files>
				<dates>
					<dateReceived><?=date("d.m.Y")?></dateReceived>
				</dates>
			</article>
		<?php endfor;?>
		</articles>
	</issue>
</journal>