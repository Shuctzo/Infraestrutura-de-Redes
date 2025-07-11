
# Pesquisa sobre Infraestrutura de Rede Hospitalar de Grande Porte

## 1. Definição de Hospital de Grande Porte

Um hospital de grande porte é geralmente definido por ter uma capacidade instalada acima de 150 leitos, podendo chegar a mais de 500 leitos. Para este projeto, consideraremos um hospital com **aproximadamente 500 leitos** como referência para o dimensionamento da infraestrutura de rede.

## 2. Equipamentos de Rede Essenciais e Dimensionamento Estimado

A infraestrutura de rede de um hospital de grande porte é complexa e deve garantir alta disponibilidade, segurança e desempenho para suportar uma vasta gama de serviços críticos. Os principais equipamentos de rede incluem:

*   **Roteadores:** Atuam como gateways entre a rede interna do hospital e a internet, além de rotear o tráfego entre diferentes VLANs e sub-redes. Para um hospital de grande porte, é essencial ter roteadores de alta capacidade e redundância para garantir a continuidade dos serviços. Serão necessários **2 a 4 roteadores** (principais e de borda, com redundância) para gerenciar o tráfego interno e externo.

*   **Switches:** São a espinha dorsal da rede local, conectando todos os dispositivos com fio. Em um hospital, a hierarquia de switches (core, distribuição e acesso) é fundamental para a performance e segmentação. Um hospital de grande porte pode ter:
    *   **Switches Core:** 2 switches de alta performance e redundantes, localizados no datacenter, para interconectar os switches de distribuição e fornecer conectividade de alta velocidade.
    *   **Switches de Distribuição:** Vários switches (ex: 10-20) que agregam o tráfego dos switches de acesso e fornecem conectividade para diferentes áreas ou andares do hospital. Cada switch de distribuição pode ter 24 a 48 portas Gigabit Ethernet.
    *   **Switches de Acesso:** Centenas de switches (ex: 50-100 ou mais, dependendo do número de pontos de rede por setor) que conectam diretamente os dispositivos finais (computadores, impressoras, equipamentos médicos, telefones IP, etc.). Estes switches geralmente possuem 24 ou 48 portas, com suporte a PoE (Power over Ethernet) para alimentar Access Points e telefones IP.

*   **Access Points (APs) Wireless:** Essenciais para fornecer conectividade sem fio para dispositivos móveis, equipamentos médicos sem fio e acesso de visitantes. A densidade de APs em um hospital é alta devido à necessidade de cobertura ubíqua e confiável, além da atenuação de sinal por paredes e equipamentos. Um grande hospital pode ter **centenas a milhares de APs** (ex: 200 a 1500+), dependendo da área construída e da densidade de usuários e dispositivos. É crucial o uso de APs com suporte a padrões recentes (Wi-Fi 6/6E) e gerenciamento centralizado (controladoras wireless).

## 3. Servidores Essenciais e Suas Funções

Os servidores em um ambiente hospitalar são cruciais para o funcionamento dos sistemas de informação e para o atendimento ao paciente. Os principais tipos e suas funções são:

*   **Servidor de Prontuários Eletrônicos (PEP/EHR):** Armazena e gerencia todas as informações clínicas dos pacientes (histórico médico, exames, diagnósticos, prescrições). É o coração do sistema de informação hospitalar e exige alta disponibilidade, segurança e capacidade de armazenamento.

*   **Servidor PACS (Picture Archiving and Communication System):** Armazena e gerencia imagens médicas (raio-X, tomografias, ressonâncias magnéticas). Requer grande capacidade de armazenamento e alta velocidade de acesso para visualização das imagens pelos médicos.

*   **Servidor de Domínio (Active Directory/LDAP):** Gerencia usuários, computadores e recursos da rede, autenticação e autorização. Essencial para a segurança e organização do ambiente de TI.

*   **Servidor DNS (Domain Name System) e DHCP (Dynamic Host Configuration Protocol):** O DNS traduz nomes de domínio em endereços IP, e o DHCP atribui endereços IP automaticamente aos dispositivos na rede. São serviços fundamentais para a conectividade.

*   **Servidor de Aplicações:** Hospeda diversas aplicações hospitalares, como sistemas de gestão hospitalar (HIS - Hospital Information System), sistemas de agendamento, faturamento, farmácia, laboratório, etc.

*   **Servidor de Banco de Dados:** Armazena os dados de todas as aplicações hospitalares. Pode ser um servidor dedicado ou parte de um servidor de aplicações, dependendo da demanda. Requer alta performance e redundância.

*   **Servidor de Backup:** Realiza o backup regular de todos os dados críticos do hospital, incluindo prontuários, imagens e configurações de sistemas. Essencial para a recuperação de desastres e conformidade com regulamentações de dados.

*   **Servidor de Virtualização (Hypervisor):** Permite a criação e gerenciamento de máquinas virtuais, otimizando o uso dos recursos de hardware e facilitando a implantação e gerenciamento de múltiplos servidores lógicos em menos máquinas físicas.

*   **Servidor de Segurança (Firewall/IDS/IPS/Proxy):** Implementa políticas de segurança, filtra tráfego malicioso, detecta e previne intrusões. Pode ser um appliance dedicado ou um servidor com software específico.

*   **Servidor de E-mail:** Gerencia as contas de e-mail internas do hospital, comunicação entre funcionários e, em alguns casos, comunicação com pacientes e fornecedores.

*   **Servidor Web:** Hospeda o site institucional do hospital, portais para pacientes, e outras aplicações web internas ou externas.

*   **Servidor de Monitoramento:** Monitora o desempenho da rede, servidores, aplicações e dispositivos, alertando sobre problemas e auxiliando na manutenção proativa.

## 4. Setores Típicos de um Hospital de Grande Porte para Segmentação de Rede

A segmentação da rede em um hospital é crucial para a segurança, desempenho e gerenciamento. Os setores típicos que podem ser segmentados em sub-redes ou VLANs incluem:

*   **Administrativo:** Escritórios, RH, Financeiro, Faturamento.
*   **Clínico/Médico:** Consultórios, Enfermarias, UTIs, Bloco Cirúrgico, Laboratórios, Radiologia.
*   **Emergência/Pronto Atendimento:** Recepção, Triagem, Consultórios de Emergência, Salas de Observação.
*   **Farmácia:** Estoque de medicamentos, dispensação.
*   **TI/Datacenter:** Servidores, equipamentos de rede core.
*   **Rede de Visitantes/Pública:** Wi-Fi para pacientes e visitantes.
*   **Equipamentos Médicos:** Dispositivos IoT médicos, equipamentos de monitoramento, máquinas de exames.
*   **Voz (VoIP):** Telefonia IP.
*   **Segurança (CFTV/Controle de Acesso):** Câmeras de segurança, sistemas de controle de acesso.

## 5. Melhores Práticas de Segurança de Rede Hospitalar

A segurança da rede em hospitais é de suma importância devido à sensibilidade dos dados dos pacientes (PHI - Protected Health Information) e à criticidade dos serviços. As melhores práticas incluem:

*   **Segmentação de Rede (VLANs/Microsegmentação):** Isolar diferentes setores e tipos de tráfego para conter possíveis ataques e limitar o acesso a dados sensíveis.
*   **Firewalls e IDS/IPS:** Implementar firewalls robustos na borda da rede e entre segmentos internos, além de sistemas de detecção e prevenção de intrusões.
*   **Controle de Acesso Baseado em Funções (RBAC):** Garantir que apenas usuários autorizados tenham acesso aos recursos e dados necessários para suas funções.
*   **Autenticação Forte:** Uso de senhas complexas, autenticação multifator (MFA) para acesso a sistemas críticos.
*   **Criptografia:** Criptografar dados em trânsito e em repouso, especialmente para PHI.
*   **Gerenciamento de Patches e Atualizações:** Manter todos os sistemas operacionais, aplicações e firmwares de equipamentos de rede atualizados para corrigir vulnerabilidades.
*   **Backup e Recuperação de Desastres:** Implementar uma política robusta de backup e um plano de recuperação de desastres para garantir a continuidade dos serviços em caso de falhas ou ataques.
*   **Monitoramento Contínuo:** Monitorar a rede 24/7 para detectar atividades suspeitas e responder rapidamente a incidentes de segurança.
*   **Treinamento de Conscientização em Segurança:** Educar os funcionários sobre as ameaças cibernéticas e as melhores práticas de segurança.
*   **Conformidade com Regulamentações:** Atender a regulamentações como LGPD (Brasil) e HIPAA (EUA) para proteção de dados de saúde.

Esta pesquisa inicial servirá como base para o planejamento detalhado da arquitetura de rede no Packet Tracer.

