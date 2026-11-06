(async () => {
  const log = [];
  const ok = (nome, passou, extra = '') => log.push(`${passou ? 'PASSOU' : 'FALHOU'} | ${nome}${extra ? ' | ' + extra : ''}`);
  const espera = ms => new Promise(r => setTimeout(r, ms));
  const ate = async f => { for (let i = 0; i < 200; i++) { if (f()) return true; await espera(50); } return false; };
  const status = () => document.querySelector('[data-status]').textContent;
  const arquivo = async nome => (await (await fetch(`/github/${nome}?ver=1`)).json());
  const coracaoDe = (raiz, nome) => [...raiz.querySelectorAll('.skin')].find(c => c.querySelector('.skin-nome').textContent === nome)?.querySelector('.coracao');
  const marcar = async id => { $(id).click(); await ate(() => !salvando && !$(id).disabled); };
  const botao = texto => [...document.querySelectorAll('button')].find(b => b.textContent === texto);
  const pedidosDeDados = () => performance.getEntriesByType('resource').map(r => r.name).filter(n => /github|loja\.json|desejos|config\.json/.test(n));

  try {
    // ---------- sem chave: nada da conta ----------
    await ate(() => situacaoCatalogo !== 'carregando');
    ok('sem chave, nenhum dado é pedido', pedidosDeDados().length === 0, pedidosDeDados().join());
    ok('sem chave, loja bloqueada', document.querySelector('.bloqueio') && !document.querySelector('#conteudo-loja .skin'));
    ok('sem chave, sem VP e sem Riot ID', $('vp').hidden && $('riot-id-loja').hidden);
    ok('sem chave, lista bloqueada', $('lista-desejos').textContent.includes('protegida'));
    ok('sem chave, ajustes travados', $('avisar-desejos').disabled && $('resumo-diario').disabled);
    ok('nada pessoal na página', !document.documentElement.outerHTML.includes('RealNome'));

    botao('Ver exemplo').click();
    await ate(() => modoExemplo && document.querySelectorAll('#conteudo-loja .skin').length === 4);
    ok('exemplo mostra a loja', document.querySelectorAll('#conteudo-loja .skin').length === 4 && $('tempo-loja').textContent === 'Skins de exemplo');
    ok('exemplo tem VP e Riot ID de mentira', $('vp').textContent === '2.350 VP' && $('riot-id-loja').textContent === 'SeuNome#BR1');
    ok('exemplo ainda não pede dados', pedidosDeDados().length === 0, pedidosDeDados().join());
    coracaoDe($('conteudo-loja'), 'Ion Sheriff').click();
    await espera(50);
    ok('exemplo não muda a lista e pede para conectar', !estaNaLista('Ion Sheriff') && !$('painel-ajustes').hidden && $('caixa-chave').open, status());
    $('aba-loja').click();
    botao('Sair do exemplo').click();
    ok('sair do exemplo volta a bloquear', document.querySelector('.bloqueio') && $('vp').hidden && !loja);

    // ---------- conectar ----------
    $('chave').value = 'errada'; $('salvar-chave').click();
    await ate(() => status().includes('não vale'));
    ok('chave errada é recusada', status().includes('não vale') && !lerChave(), status());

    $('chave').value = 'token-teste'; $('salvar-chave').click();
    await ate(() => status().includes('conectada'));
    ok('chave certa conecta', status().includes('conectada') && lerChave() === 'token-teste' && $('chave').value === '', status());
    ok('Riot ID real aparece', $('riot-id-loja').textContent === 'RealNome#123' && $('riot-id-ajustes').textContent === 'RealNome#123', $('riot-id-loja').textContent);
    ok('saldo real aparece', $('vp').textContent === '1.000 VP', $('vp').textContent);
    ok('tempo até trocar', /^Troca em \d+h \d+min$/.test($('tempo-loja').textContent), $('tempo-loja').textContent);
    ok('com chave, ajustes liberados', !$('avisar-desejos').disabled && !$('resumo-diario').disabled);
    ok('acento lido certo', desejos.includes('Skin Ação'), desejos.join(' / '));

    // ---------- loja de ontem ----------
    const lojaHoje = () => document.querySelectorAll('#conteudo-loja > section .skin').length;
    const ontemBotao = () => document.querySelector('.botao-ontem');
    ok('foco na loja do dia: ontem fechada', document.querySelectorAll('#conteudo-loja .skin').length === 4 && !document.querySelector('.loja-ontem'));
    ok('botão de ontem com a data', ontemBotao().textContent.includes('Ver loja de ontem') && ontemBotao().textContent.includes('05/11') && ontemBotao().getAttribute('aria-expanded') === 'false', ontemBotao().textContent);
    ok('sem título de ontem na tela', ![...document.querySelectorAll('#conteudo-loja h2')].some(h => /ontem/i.test(h.textContent)));
    ontemBotao().click();
    ok('tocar abre a loja de ontem', document.querySelectorAll('.loja-ontem .skin').length === 4 && lojaHoje() === 4 && ontemBotao().getAttribute('aria-expanded') === 'true' && ontemBotao().textContent.includes('Esconder'), ontemBotao().textContent);
    ok('preço na loja de ontem', document.querySelectorAll('.loja-ontem .preco').length === 4);
    ontemBotao().click();
    ok('tocar de novo fecha', !document.querySelector('.loja-ontem'));

    const dataOntem = loja.ontem.data;
    loja.ontem.data = '2026-11-01'; desenharLoja();
    ok('robô falhou um dia: vira loja anterior', ontemBotao().textContent.includes('Ver loja anterior') && ontemBotao().textContent.includes('01/11'), ontemBotao().textContent);
    loja.ontem.data = dataOntem;
    const ontemGuardada = loja.ontem;
    loja.ontem = null; desenharLoja();
    ontemBotao().click();
    ok('sem loja de ontem, explica', document.querySelector('.loja-ontem').textContent.includes('segundo dia'));
    ontemBotao().click();
    loja.ontem = ontemGuardada; desenharLoja();

    // ---------- ajustes e lista salvos no repositório ----------
    $('aba-ajustes').click();
    await marcar('resumo-diario');
    let config = await arquivo('config.json');
    ok('ajuste cria o arquivo', config && JSON.parse(config.texto).resumo_diario === true, config && config.texto.replace(/\s+/g, ' '));

    await fetch('/github/config.json?falhar=500');
    await marcar('resumo-diario');
    ok('erro desfaz o ajuste', $('resumo-diario').checked === true && status().includes('erro 500'), status());

    $('aba-desejos').click();
    await ate(() => situacaoCatalogo === 'ok');
    $('busca').value = 'oni phan'; $('busca').dispatchEvent(new Event('input'));
    coracaoDe($('resultados'), 'Oni Phantom').click();
    await ate(() => status().includes('entrou'));
    let texto = (await arquivo('desejos.txt')).texto;
    ok('adicionar salva', texto.includes('Oni Phantom') && texto.includes('Skin Ação'), JSON.stringify(texto));

    await fetch('/github/desejos.txt?falhar=409');
    coracaoDe($('resultados'), 'Oni Phantom').click();
    await ate(() => status().includes('saiu'));
    texto = (await arquivo('desejos.txt')).texto;
    ok('conflito não perde mudança de fora', texto.includes('Vinda De Outro Lugar') && !texto.includes('Oni Phantom'), JSON.stringify(texto));

    await fetch('/github/desejos.txt?falhar=500');
    const antes = [...desejos];
    coracaoDe($('resultados'), 'Oni Phantom').click();
    await ate(() => status().includes('erro 500'));
    ok('erro desfaz a lista', desejos.join() === antes.join(), status());

    // ---------- remover a chave apaga tudo da tela ----------
    $('remover-chave').click();
    ok('remover chave limpa o aparelho', !lerChave() && !chave);
    ok('remover chave esconde os dados', document.querySelector('.bloqueio') && $('vp').hidden && $('riot-id-loja').hidden && !loja && desejos.length === 0);
    ok('remover chave tira o Riot ID dos ajustes', !$('riot-id-ajustes').textContent.includes('RealNome'));
  } catch (e) {
    ok('roteiro terminou', false, e.message + ' ' + (e.stack || '').split('\n')[1]);
  }
  const saida = document.createElement('pre');
  saida.id = 'resultado';
  saida.textContent = log.join('\n');
  document.body.append(saida);
})();
